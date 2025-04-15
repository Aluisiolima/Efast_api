<?php
    namespace App\Controllers;

    use App\Http\Response;

    class NotFoundController
    {
        private readonly Response $response;

        public function __construct(){
            $this->response = new Response;
        }
        
        public function index(): void
        {
            $this->response::json(["error" => "Essa rota nao existe!!!"],404, true);
            return;
        }
    }