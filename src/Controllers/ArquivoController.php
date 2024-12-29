<?php 
    namespace App\Controllers;

use App\Http\Response;
use App\Http\Resquest;
use App\Services\ArquivoServices;

    class ArquivoController
    {
        public function pegarArquivo(Resquest $resquest, Response $response)
        {
            $auth = $resquest::authorization();

            $arquivo = ArquivoServices::pegarArquivo($auth);

            if(isset($arquivo["unauthorized"])){
                $response::json($arquivo, 401, true);
                return;
            }
            if(isset($arquivo["error"])){
                $response::json($arquivo, 400, true);
                return;
            }

            $response::json($arquivo, 200);
        }

        public function deleteArquivo(Resquest $resquest, Response $response)
        {
            $body = $resquest::getBody();
            $auth = $resquest::authorization();

            $arquivo = ArquivoServices::deleteArquivo($body, $auth);

            if(isset($arquivo["unauthorized"])){
                $response::json($arquivo, 401, true);
                return;
            }
            if(isset($arquivo["error"])){
                $response::json($arquivo, 400, true);
                return;
            }

            $response::json($arquivo, 200);
        }
    }