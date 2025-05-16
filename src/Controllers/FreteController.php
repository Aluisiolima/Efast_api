<?php
    namespace App\Controllers;
    
    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\FreteServices;

    class FreteController extends ControllerBase
    {
        public function __construct(
            private readonly Resquest $resquest,
            private readonly Response $response,
            private readonly FreteServices $freteServices
        ){
            parent::__construct($response);
        }    
        
        public function calcFrete(string $id): void
        {
            $body = $this->resquest::getBody();
            $empresa = $this->freteServices->calcFrete($body, (int) $id);

            $this->responserController($empresa, 200);
        }

        public function frete(): void
        {
            $auth = $this->resquest::authorization();
            $body = $this->resquest::getBody();
            $empresa = $this->freteServices->frete($body, $auth);

            $this->responserController($empresa, 200);
        }
    }