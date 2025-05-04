<?php 
    namespace App\Controllers;

    use App\Controllers\ControllerBase;
    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\ArquivoServices;

    class ArquivoController extends ControllerBase
    {
        public function __construct(
            private readonly Resquest $resquest,
            private readonly Response $response,
            private readonly ArquivoServices $arquivoServices
        ){
            parent::__construct( $response);
        }

        public function pegarArquivo()
        {
            $auth = $this->resquest::authorization();

            $arquivo = $this->arquivoServices->pegarArquivo($auth);

            $this->responserController($arquivo, 200);
        }

        public function inserirArquivo()
        {
            $auth = $this->resquest::authorization();
            $body = $this->resquest::getBody();

            $arquivo = $this->arquivoServices->inserirArquivo($body, $auth);

            $this->responserController($arquivo, 201);
        }

        public function deleteArquivo()
        {
            $body = $this->resquest::getBody();
            $auth = $this->resquest::authorization();

            $arquivo = $this->arquivoServices->deleteArquivo($body, $auth);

            $this->responserController($arquivo, 200);
        }
    }