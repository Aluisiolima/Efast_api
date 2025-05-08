<?php 
    namespace App\Controllers;

    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\QrCodeServices;

    class QrCodeController extends ControllerBase
    {
        public function __construct(
            private readonly Resquest $resquest,
            private readonly Response $response,
            private readonly QrCodeServices $qrCodeServices
        ){
            parent::__construct($response);
        }    
        
        public function qrcode(): void
        {
            $auth = $this->resquest->authorization();
            $empresa = $this->qrCodeServices->qrcode($auth);
            
            if (is_array($empresa) and isset($empresa["error"])) {
                $this->responserController($empresa, 400);
                return;
            }

            $this->response->files($empresa->getString(), $empresa->getMimeType());
        }
    }