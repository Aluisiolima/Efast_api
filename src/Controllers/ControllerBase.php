<?php
    namespace App\Controllers;
    
    use App\Http\Response;

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

        public function responserFiles(mixed $file, mixed $type): void
        {
            if (isset($file["unauthorized"])){
                $this->response::json($file,401,true);
                return;
            }

            if (isset($file["error"])) {
                $this->response::json($file,400,true);
                return;
            }

            $this->response::files($file,$type);
        }
    }