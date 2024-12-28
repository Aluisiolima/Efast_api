<?php
    namespace App\Controllers;

    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\VendaServices;

    class VendaController
    {
        public function pegarVendas(Resquest $resquest, Response $response)
        {
            $auth = $resquest->authorization();
            $vendas = VendaServices::pegarVendas($auth);

            if (isset($user["unauthorized"])){
                $response::json($vendas,401,true);
                return;
            }

            if (isset($vendas["error"])) {
                $response::json($vendas, 400, true);
                return;
            }

            $response::json($vendas, 200);
        }

        public function pegarVendasDay(Resquest $resquest, Response $response)
        {
            $auth = $resquest->authorization();
            $vendas = VendaServices::pegarVendasDay($auth);

            if (isset($user["unauthorized"])){
                $response::json($vendas,401,true);
                return;
            }
            if (isset($vendas["error"])){
                $response::json($vendas, 400, true);
                return;
            }

            $response::json($vendas, 200);
        }
    }