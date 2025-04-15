<?php
    namespace App\Controllers;

    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\EmpresaServices;

    class EmpresaController 
    {
        private readonly Resquest $resquest;
        private readonly Response $response;

        public function __construct(){
            $this->resquest = new Resquest;
            $this->response = new Response;
        }

        public function pegarEmpresa(): void
        {

            $empresa = EmpresaServices::pegarEmpresa();

            if (isset($empresa["error"])) {
                $this->response::json($empresa,400,true);
                return;
            }

            $this->response::json($empresa,200);
        }
        public function pegarEmpresaOne(array $id)
        {

            $empresa = EmpresaServices::pegarEmpresaOne($id[0]);

            if (isset($empresa["error"])) {
                $this->response::json($empresa,400,true);
                return;
            }

            $this->response::json($empresa,200);
        }
        public function inserirEmpresa()
        {
            $body = $this->resquest::getBody();
            $auth = $this->resquest::authorization();

            $empresa = EmpresaServices::inserirEmpresa($body,$auth);

            if (isset($empresa["unauthorized"])){
                $this->response::json($empresa,401,true);
                return;
            }

            if (isset($empresa["error"])) {
                $this->response::json($empresa,400,true);
                return;
            }

            $this->response::json($empresa,200);
        }
        public function updateEmpresa()
        {
            $body = $this->resquest::getBody();
            $auth = $this->resquest::authorization();

            $empresa = EmpresaServices::updateEmpresa($body,$auth);

            if (isset($empresa["unauthorized"])){
                $this->response::json($empresa,401,true);
                return;
            }

            if (isset($empresa["error"])) {
                $this->response::json($empresa,400,true);
                return;
            }

            $this->response::json($empresa,200);
        }
        public function desativaEmpresa()
        {
            $body = $this->resquest::getBody();
            $auth = $this->resquest::authorization();

            $empresa = EmpresaServices::desativaEmpresa($body,$auth);

            if (isset($empresa["unauthorized"])){
                $this->response::json($empresa,401,true);
                return;
            }

            if (isset($empresa["error"])) {
                $this->response::json($empresa,400,true);
                return;
            }

            $this->response::json($empresa,200);
        }

        public function ativaEmpresa()
        {
            $body = $this->resquest::getBody();
            $auth = $this->resquest::authorization();

            $empresa = EmpresaServices::ativaEmpresa($body,$auth);

            if (isset($empresa["unauthorized"])){
                $this->response::json($empresa,401,true);
                return;
            }

            if (isset($empresa["error"])) {
                $this->response::json($empresa,400,true);
                return;
            }

            $this->response::json($empresa,200);
        }

        public function calcFrete(array $id)
        {
            $body = $this->resquest::getBody();
            $empresa = EmpresaServices::calcFrete($body,$id[0]);

            if(isset($empresa["error"])) {
              $this->response::json($empresa, 400, true);
              return;
            }

            $this->response::json($empresa, 200);
        }

        public function frete()
        {
            $auth = $this->resquest::authorization();
            $body = $this->resquest::getBody();
            $empresa = EmpresaServices::frete($body, $auth);

            if (isset($empresa["unauthorized"])){
                $this->response::json($empresa,401,true);
                return;
            }

            if (isset($empresa["error"])) {
                $this->response::json($empresa,400,true);
                return;
            }

            $this->response::json($empresa,200);
        }
    }