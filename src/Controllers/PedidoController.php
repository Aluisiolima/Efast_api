<?php
    namespace App\Controllers;

use App\Http\Response;
use App\Http\Resquest;
use App\Services\PedidoServices;

    class PedidoController
    {

        public static function InserirPedido(Resquest $resquest, Response $response, array $id): void
        {
            $body = $resquest::getBody();
            $pedido = PedidoServices::inserirPedido($body, $id[0]);

            if (isset($pedido["error"])) {
                $response::json($pedido,400, true);
                return;
            }

            $response::json($pedido,200);
        }
    }