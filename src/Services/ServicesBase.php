<?php   
    namespace App\Services;
    use App\Http\JWToken;
    use App\Errors\AuthError;

    class ServicesBase
    {
        public function __construct(
            private readonly JWToken $jwtoken
        ) {}

        public function verificaToken(mixed $auth): object
        {
            if (isset($auth["error"])) {
                throw new AuthError($auth["error"]);
            }

            $token = $this->jwtoken->validateToken($auth);
            if (!$token) throw new AuthError("Você não está autorizado a essa operação. Faça login.");

            return $token;
        }
    }