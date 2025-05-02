<?php
    namespace App\Controllers;

    use App\Controllers\ControllerBase;
    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\EmpresaServices;

    class EmpresaController extends ControllerBase
    {
        public function __construct(
            private readonly Resquest $resquest,
            private readonly Response $response,
            private readonly EmpresaServices $empresaServices
        ){
            parent::__construct($response);
        }    

        public function pegarEmpresa(): void
        {
            $empresa = $this->empresaServices->pegarEmpresa();

            $this->responserController($empresa, 200);
        }
        public function pegarEmpresaOne(string $id)
        {
            $empresa = $this->empresaServices->pegarEmpresaOne((int) $id);

            $this->responserController($empresa, 200);
        }
        public function inserirEmpresa()
        {
            $body = $this->resquest::getBody();
            $auth = $this->resquest::authorization();

            $empresa = $this->empresaServices->inserirEmpresa($body,$auth);

            $this->responserController($empresa, 200);
        }
        public function updateEmpresa()
        {
            $body = $this->resquest::getBody();
            $auth = $this->resquest::authorization();

            $empresa = $this->empresaServices->updateEmpresa($body,$auth);

            $this->responserController($empresa, 200);
        }
        public function desativaEmpresa()
        {
            $body = $this->resquest::getBody();
            $auth = $this->resquest::authorization();

            $empresa = $this->empresaServices->desativaEmpresa($body,$auth);

            $this->responserController($empresa, 200);
        }

        public function ativaEmpresa()
        {
            $body = $this->resquest::getBody();
            $auth = $this->resquest::authorization();

            $empresa = $this->empresaServices->ativaEmpresa($body,$auth);

            $this->responserController($empresa, 200);
        }
    }