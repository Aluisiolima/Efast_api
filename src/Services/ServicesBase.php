<?php   
    namespace App\Services;
    use App\Http\JWToken;

    class ServicesBase
    {
        public function __construct(
            protected readonly JWToken $jwtoken
        ) {}

        public function verificaToken(mixed $auth): array | object
        {
            if (isset($auth["error"])) {
                return ["unauthorized" => $auth["error"]];
            }

            $token = $this->jwtoken->validateToken($auth);
            if (!$token) return ["unauthorized" => "Você não está autorizado a essa operação. Faça login."];

            return $token;
        }
    }