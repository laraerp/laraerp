<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;

class ConfiguracoesController extends BaseController {

    /**
     * Configuracoes
     *
     * @return Response
     */
    public function getIndex() {
        return View::make('configuracoes');
    }

}
