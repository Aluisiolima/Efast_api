<?php 
    namespace App\Controllers;

    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\ArquivoServices;

    class ArquivoController
    {
        private readonly Resquest $resquest;
        private readonly Response $response;

        public function __construct(){
            $this->resquest = new Resquest;
            $this->response = new Response;
        }

        public function pegarArquivo()
        {
            $auth = $this->resquest::authorization();

            $arquivo = ArquivoServices::pegarArquivo($auth);

            if(isset($arquivo["unauthorized"])){
                $this->response::json($arquivo, 401, true);
                return;
            }
            if(isset($arquivo["error"])){
                $this->response::json($arquivo, 400, true);
                return;
            }

            $this->response::json($arquivo, 200);
        }

        public function inserirArquivo()
        {
            $auth = $this->resquest::authorization();
            $body = $this->resquest::getBody();

            $arquivo = ArquivoServices::inserirArquivo($body, $auth);

            if(isset($arquivo["unauthorized"])){
                $this->response::json($arquivo, 401, true);
                return;
            }
            if(isset($arquivo["error"])){
                $this->response::json($arquivo, 400, true);
                return;
            }

            $this->response::json($arquivo, 200);
        }

        public function deleteArquivo()
        {
            $body = $this->resquest::getBody();
            $auth = $this->resquest::authorization();

            $arquivo = ArquivoServices::deleteArquivo($body, $auth);

            if(isset($arquivo["unauthorized"])){
                $this->response::json($arquivo, 401, true);
                return;
            }
            if(isset($arquivo["error"])){
                $this->response::json($arquivo, 400, true);
                return;
            }

            $this->response::json($arquivo, 200);
        }
    }