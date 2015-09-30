<?php

namespace Laraerp\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Whoops\Handler\JsonResponseHandler;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

class WhoopsHandler extends Handler
{

    /**
     * Render an exception into a response.
     *
     * @param Request $request
     * @param Exception $e
     * @return Response
     */
    public function render($request, Exception $e) {
        $whoops = new Run;

        if ($request->ajax())
        {
            $whoops->pushHandler(new JsonResponseHandler());
        }
        else
        {
            $whoops->pushHandler(new PrettyPageHandler());
        }

        return new Response($whoops->handleException($e), $e->getStatusCode(), $e->getHeaders());
    }

}