<?php
    namespace App\Controllers;

    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\VendaServices;

    class VendaController
    {
        public function pegarVendas(Resquest $resquest, Response $response, array $id)
        {
            $vendas = VendaServices::pegarVendas($id);

            if (isset($vendas["error"])) 
            {
                $response::json($vendas["error"], 400, true);
                return;
            }

            $response::json($vendas, 200);
        }
    }