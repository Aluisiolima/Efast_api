<?php
    namespace App\Controllers;

    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\VendaServices;

    class VendaController
    {
        public function pegarVendas(Resquest $resquest, Response $response)
        {
            $body = $resquest->getBody();
            $vendas = VendaServices::pegarVendas($body);

            if (isset($vendas["error"])) 
            {
                $response::json($vendas, 400, true);
                return;
            }

            $response::json($vendas, 200);
        }

        public function pegarVendasDay(Resquest $resquest, Response $response)
        {
            $body = $resquest->getBody();
            $vendas = VendaServices::pegarVendasDay($body);

            if (isset($vendas["error"])) 
            {
                $response::json($vendas, 400, true);
                return;
            }

            $response::json($vendas, 200);
        }
    }