<?php
    namespace App\Http;
    
    /**
     * Class Resquest
     * 
     * Esta classe é responsável por receber requisições HTTP.
     */

    class Resquest
    {
        /**
         * Verifica o metodo da requisição do cliente.
         *
         * @return string
         */
        public static function method(): string
        {
            return $_SERVER["REQUEST_METHOD"];
        }

        /**
         * Pegar os dados passados na requisição do cliente.
         *
         * @return mixed
         */
        public static function getBody(): mixed
        {
            $json = json_decode(file_get_contents("php://input"), true) ?? [];

            $data = match (self::method()) {
                "GET" => $_GET,
                "POST" => !empty($_FILES) ? array_merge($json, $_FILES) : $json,
                "PUT", "DELETE" => $json,
            };

            return $data;
        }

        /**
         * Retorna o token passado pela requisicao ou um array de error caso nao passase o token
         *
         * @return array|string
         */
        public static function authorization(): array|string
        {
            $authorization = getallheaders();

            if (!isset($authorization["Authorization"])) return ["error" => "Desculpada mais voce nao passou o Token"];

            $authorizationPartials = explode(" ", $authorization["Authorization"]);

            if (count($authorizationPartials) != 2) return ["error"=> "O token foi passado errado confira-lo..."];

            return $authorizationPartials[1] ?? "";
        }
    }