<?php
    namespace App\Controllers;

    use App\Http\Response;
    use App\Http\Resquest;

    class NotFoundController
    {
        public function index(Resquest $resquest, Response $response): void
        {
            $response::json(["error" => "Essa rota nao existe!!!"],404, true);
            return;
        }
    }