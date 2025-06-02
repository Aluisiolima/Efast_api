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

        public function pegarArquivo(): void
        {
            $auth = $this->resquest::authorization();

            $arquivo = $this->arquivoServices->pegarArquivo($auth);

            $this->responserController($arquivo, 200);
        }

        public function inserirArquivo(): void
        {
            $auth = $this->resquest::authorization();
            $body = $this->resquest::getBody();

            $arquivo = $this->arquivoServices->inserirArquivo($body, $auth);

            $this->responserController($arquivo, 201);
        }

        public function deleteArquivo(int $id): void
        {
            $auth = $this->resquest::authorization();

            $arquivo = $this->arquivoServices->deleteArquivo($id, $auth);

            $this->responserController($arquivo, 200);
        }
    }