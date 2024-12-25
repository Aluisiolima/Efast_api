<?php
    namespace App\Controllers;

use App\Http\Response;
use App\Http\Resquest;
use App\Services\PedidoServices;

    class PedidoController
    {

        public static function InserirPedido(Resquest $resquest, Response $response): void
        {
            $body = $resquest::getBody();
            $pedido = PedidoServices::inserirPedido($body);

            if (isset($pedido["error"])) {
                $response::json($pedido["error"],400, true);
                return;
            }

            $response::json($pedido,200);
        }
    }