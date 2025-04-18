<?php
    namespace App\Controllers;

    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\VendaServices;

    class VendaController
    {
        private readonly Resquest $resquest;
        private readonly Response $response;

        public function __construct(){
            $this->resquest = new Resquest;
            $this->response = new Response;
        }

        public function pegarVendas()
        {
            $auth = $this->resquest->authorization();
            $vendas = VendaServices::pegarVendas($auth);

            if (isset($vendas["unauthorized"])){
                $this->response::json($vendas,401,true);
                return;
            }

            if (isset($vendas["error"])) {
                $this->response::json($vendas, 400, true);
                return;
            }

            $this->response::json($vendas, 200);
        }

        public function pegarVendasDay()
        {
            $auth = $this->resquest->authorization();
            $vendas = VendaServices::pegarVendasDay($auth);

            if (isset($vendas["unauthorized"])){
                $this->response::json($vendas,401,true);
                return;
            }
            if (isset($vendas["error"])){
                $this->response::json($vendas, 400, true);
                return;
            }

            $this->response::json($vendas, 200);
        }
    }