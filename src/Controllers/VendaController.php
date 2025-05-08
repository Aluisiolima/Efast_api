<?php
    namespace App\Controllers;

    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\VendaServices;
    use App\Controllers\ControllerBase;

    class VendaController extends ControllerBase
    {
        public function __construct(
            private readonly Resquest $resquest,
            private readonly Response $response,
            private readonly VendaServices $vendaServices
        ){
            parent::__construct($response);
        }

        public function pegarVendas(): void
        {
            $auth = $this->resquest->authorization();
            $vendas = $this->vendaServices->pegarVendas($auth);

            $this->responserController($vendas, 200);
        }

        public function pegarVendasDay(): void
        {
            $auth = $this->resquest->authorization();
            $vendas = $this->vendaServices->pegarVendasDay($auth);

            $this->responserController($vendas, 200);
        }
    }