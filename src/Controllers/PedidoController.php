<?php
    namespace App\Controllers;

    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\PedidoServices;

    class PedidoController
    {
        private readonly Resquest $resquest;
        private readonly Response $response;

        public function __construct(){
            $this->resquest = new Resquest;
            $this->response = new Response;
        }

        public function inserirPedido(array $id): void
        {
            $body = $this->resquest::getBody();
            $pedido = PedidoServices::inserirPedido($body, $id[0]);

            if (isset($pedido["error"])) {
                $this->response::json($pedido,400, true);
                return;
            }

            $this->response::json($pedido,200);
        }
        public function status(array $id): void
        {
            $auth = $this->resquest::authorization();
            $body = $this->resquest::getBody();
            $pedido = PedidoServices::status($body, $id[0], $auth);

            if (isset($pedido["error"])) {
                $this->response::json($pedido,400, true);
                return;
            }
            if (isset($pedido["unauthorized"])){
                $this->response::json($pedido,401,true);
                return;
            }

            $this->response::json($pedido,200);
        }
    }