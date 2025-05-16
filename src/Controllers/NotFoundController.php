<?php
    namespace App\Controllers;

    use App\Http\Response;

    class NotFoundController
    {
        public function __construct(
            private readonly Response $response
        ){}
        
        public function index(): void
        {
            $this->response->json(["error" => "Essa rota nao existe!!!"],404);
            return;
        }
    }