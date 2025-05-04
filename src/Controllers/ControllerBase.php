<?php
    namespace App\Controllers;
    
    use App\Http\Response;
use Endroid\QrCode\Writer\Result\ResultInterface;

    class ControllerBase
    {
        public function __construct(
            private readonly Response $response
        ){}    

        public function responserController(array $data, int $statusCode): void
        {
            if (isset($data["unauthorized"])){
                $this->response::json($data,401,true);
                return;
            }

            if (isset($data["error"])) {
                $this->response::json($data,400,true);
                return;
            }

            $this->response::json($data,$statusCode);
        }
    }