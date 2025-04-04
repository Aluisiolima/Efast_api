<?php
    namespace App\Controllers;

    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\EmpresaServices;

    class EmpresaController
    {
        public function pegarEmpresa(Resquest $resquest, Response $response)
        {

            $empresa = EmpresaServices::pegarEmpresa();

            if (isset($empresa["error"])) {
                $response::json($empresa,400,true);
                return;
            }

            $response::json($empresa,200);
        }
        public function pegarEmpresaOne(Resquest $resquest, Response $response, array $id)
        {

            $empresa = EmpresaServices::pegarEmpresaOne($id[0]);

            if (isset($empresa["error"])) {
                $response::json($empresa,400,true);
                return;
            }

            $response::json($empresa,200);
        }
        public function inserirEmpresa(Resquest $resquest, Response $response)
        {
            $body = $resquest::getBody();
            $auth = $resquest::authorization();

            $empresa = EmpresaServices::inserirEmpresa($body,$auth);

            if (isset($empresa["unauthorized"])){
                $response::json($empresa,401,true);
                return;
            }

            if (isset($empresa["error"])) {
                $response::json($empresa,400,true);
                return;
            }

            $response::json($empresa,200);
        }
        public function updateEmpresa(Resquest $resquest, Response $response)
        {
            $body = $resquest::getBody();
            $auth = $resquest::authorization();

            $empresa = EmpresaServices::updateEmpresa($body,$auth);

            if (isset($empresa["unauthorized"])){
                $response::json($empresa,401,true);
                return;
            }

            if (isset($empresa["error"])) {
                $response::json($empresa,400,true);
                return;
            }

            $response::json($empresa,200);
        }
        public function desativaEmpresa(Resquest $resquest, Response $response)
        {
            $body = $resquest::getBody();
            $auth = $resquest::authorization();

            $empresa = EmpresaServices::desativaEmpresa($body,$auth);

            if (isset($empresa["unauthorized"])){
                $response::json($empresa,401,true);
                return;
            }

            if (isset($empresa["error"])) {
                $response::json($empresa,400,true);
                return;
            }

            $response::json($empresa,200);
        }

        public function ativaEmpresa(Resquest $resquest, Response $response)
        {
            $body = $resquest::getBody();
            $auth = $resquest::authorization();

            $empresa = EmpresaServices::ativaEmpresa($body,$auth);

            if (isset($empresa["unauthorized"])){
                $response::json($empresa,401,true);
                return;
            }

            if (isset($empresa["error"])) {
                $response::json($empresa,400,true);
                return;
            }

            $response::json($empresa,200);
        }

        public function calcFrete(Resquest $resquest, Response $response, array $id)
        {
            $body = $resquest::getBody();
            $empresa = EmpresaServices::calcFrete($body,$id[0]);

            if(isset($empresa["error"])) {
              $response::json($empresa, 400, true);
              return;
            }

            $response::json($empresa, 200);
        }

        public function frete(Resquest $resquest, Response $response)
        {
            $auth = $resquest::authorization();
            $body = $resquest::getBody();
            $empresa = EmpresaServices::frete($body, $auth);

            if (isset($empresa["unauthorized"])){
                $response::json($empresa,401,true);
                return;
            }

            if (isset($empresa["error"])) {
                $response::json($empresa,400,true);
                return;
            }

            $response::json($empresa,200);
        }
    }