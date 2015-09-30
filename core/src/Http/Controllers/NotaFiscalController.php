<?php

namespace Laraerp\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Laraerp\Contracts\Repositories\NotaFiscalRepository;
use Laraerp\Http\Services\ImportarNFeService;

class NotaFiscalController extends Controller
{
    /**
     * Repositorio de notas fiscais
     *
     * @var NotaFiscalRepository
     */
    private $notaFiscalRepository;

    /**
     * NotaFiscalController constructor.
     *
     * @param $notaFiscalRepository
     */
    public function __construct(NotaFiscalRepository $notaFiscalRepository)
    {
        $this->notaFiscalRepository = $notaFiscalRepository;
    }

    /**
     * Exibe formulario para o usuario enviar suas notas fiscais eletronicas
     *
     * @return Response
     */
    public function importar()
    {
        return view('notafiscal.importar');
    }

    /**
     * Recebe o upload da NFe e processa
     *
     * @return JsonResponse
     */
    public function upload(Request $request, ImportarNFeService $service)
    {
        $file = $request->file('file');

        DB::beginTransaction();

        try{
            $message = $service->setXml($file)->processar();

            DB::commit();

            return response()->json(['code' => 0, 'message' => $message]);

        }catch (Exception $e){

            DB::rollBack();

            return response()->json(['code' => 99, 'message' => $e->getMessage()]);
        }

    }

    /**
     * Exibe DANFE
     *
     * @return Response
     */
    public function danfe($id)
    {
        $notafiscal = $this->notaFiscalRepository->getById($id);

        if(is_null($notafiscal))
            return redirect()->back()->with('erro', 'Nota fiscal não encontrada')->withInput();

        $danfe = new \DanfeNFePHP(file_get_contents($notafiscal->path_xml), 'P', 'A4', '', 'I', '');
        $danfe->printDANFE($danfe->montaDANFE().'.pdf', 'I');
    }

    /**
     * Exibe XML
     *
     * @return Response
     */
    public function xml($id)
    {
        $notafiscal = $this->notaFiscalRepository->getById($id);

        if(is_null($notafiscal))
            return redirect()->back()->with('erro', 'Nota fiscal não encontrada')->withInput();

        return response()->make(file_get_contents($notafiscal->path_xml), 200, ['Content-Type' => 'application/xml']);
    }

}
