<?php
    namespace App\Controllers;

    use App\Controllers\ControllerBase;
    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\PedidoServices;

    class PedidoController extends ControllerBase
    {
        public function __construct(
            private readonly Resquest $resquest,
            private readonly Response $response,
            private readonly PedidoServices $pedidoServices,
        ){
            parent::__construct($response);
        }

        public function inserirPedido(string $id): void
        {
            $body = $this->resquest::getBody();
            $pedido = $this->pedidoServices->inserirPedido($body, (int) $id);

            $this->responserController($pedido, 201);
        }
        
        public function status(string $id): void
        {
            $auth = $this->resquest::authorization();
            $body = $this->resquest::getBody();
            $pedido = $this->pedidoServices->status($body, (int) $id, $auth);
            
            $this->responserController($pedido, 200);
        }
    }