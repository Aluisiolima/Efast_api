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
                $this->response::json([
                    "error" => true,
                    "message" => "Token inválido ou expirado"
                ],401);
                return;
            }

            if (isset($data["error"])) {
                $this->response::json([
                    "error" => true,
                    "message" => $data["error"]
                ],400);
                return;
            }

            $this->response::json([
                "error" => false,
                "success" => true,
                "data" => $data
            ],$statusCode);
        }
    }