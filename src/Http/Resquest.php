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
            $json = json_decode(file_get_contents('php://input'), true) ?? [];

            $data = match (self::method()) {
                'GET' => $_GET,
                'POST' => !empty($_FILES) ? array_merge($json, $_FILES) : $json,
                'PUT', 'DELETE' => $json,
            };

            return $data;
        }
    }