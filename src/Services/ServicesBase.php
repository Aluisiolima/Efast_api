<?php   
    namespace App\Services;
    use App\Http\JWToken;
    use Exception;

    class ServicesBase
    {
        public function __construct(
            private readonly JWToken $jwtoken
        ) {}

        public function verificaToken(mixed $auth): object
        {
            if (isset($auth["error"])) {
                throw new Exception($auth["error"]);
            }

            $token = $this->jwtoken->validateToken($auth);
            if (!$token) throw new Exception("Você não está autorizado a essa operação. Faça login.");

            return $token;
        }
    }