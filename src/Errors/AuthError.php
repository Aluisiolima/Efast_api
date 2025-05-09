<?php 
    namespace App\Errors;

    use App\Http\Response;
    use Exception;
    class AuthError extends Exception
    {
        public function __construct($message = "Erro de autenticação")
        {
            Response::json(["error" => $message], 401);
        }
    }