<?php
    namespace App\Controllers;

use App\Http\Response;
use App\Http\Resquest;
use App\Services\PedidoServices;

    class PedidoController
    {

        public static function inserirPedido(Resquest $resquest, Response $response, array $id): void
        {
            $body = $resquest::getBody();
            $pedido = PedidoServices::inserirPedido($body, $id[0]);

            if (isset($pedido["error"])) {
                $response::json($pedido,400, true);
                return;
            }

            $response::json($pedido,200);
        }
        public static function status(Resquest $resquest, Response $response, array $id): void
        {
            $auth = $resquest::authorization();
            $body = $resquest::getBody();
            $pedido = PedidoServices::status($body, $id[0], $auth);

            if (isset($pedido["error"])) {
                $response::json($pedido,400, true);
                return;
            }
            if (isset($pedido["unauthorized"])){
                $response::json($pedido,401,true);
                return;
            }

            $response::json($pedido,200);
        }
    }