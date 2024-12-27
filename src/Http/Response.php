<?php
    namespace App\Http;

    use App\Utils\Logs;

    /**
     * Class Response
     * 
     * Esta classe é responsável por enviar respostas HTTP.
     */
    class Response
    {
        /**
         * Envia uma resposta JSON ao cliente.
         *
         * @param array|string $data Dados a serem enviados na resposta.
         * @param int $status Código de status HTTP.
         * @param bool $error Indica se a resposta é um erro.
         *
         * @return void
         */
        public static function json(array|string $data = [], int $status = 200, bool $error = false): void
        {
            self::setHeaders($status);
        
            $response = $error 
                ? self::errorResponse($data, $status)
                : self::successResponse($data);
            
            
            echo self::safeJsonEncode($response);
        }
        
        /**
         * Define os cabeçalhos da resposta.
         *
         * @param int $status Código de status HTTP.
         *
         * @return void
         */
        private static function setHeaders(int $status): void
        {
            http_response_code($status);
            header("Content-Type: application/json");
        }
        
        /**
         * Formata uma resposta de sucesso.
         *
         * @param array|string $data Dados a serem incluídos na resposta.
         *
         * @return array Resposta formatada.
         */
        private static function successResponse(array|string $data): array
        {
            return [
                "error"   => false,
                "success" => true,
                "data"    => is_array($data) ? $data : [$data],
            ];
        }
        
        /**
         * Formata uma resposta de erro.
         *
         * @param array|string $data Mensagem de erro ou dados adicionais.
         *
         * @return array Resposta formatada.
         */
        private static function errorResponse(array $data, int $status): array
        {
            Logs::Log($data, $status);

            $message = "";

            if(isset($data["error"]))
            {
                $message = $data["error"];
            }
            if(isset($data["unauthorized"]))
            {
                $message = $data["unauthorized"];
            }
            return [
                "error"   => true,
                "message" => $message,
            ];
        }
        
        /**
         * Codifica os dados da resposta em JSON de forma segura.
         *
         * @param array $response Dados a serem codificados.
         *
         * @return string JSON codificado ou mensagem de erro.
         */
        private static function safeJsonEncode(array $response): string
        {
            $json = json_encode($response);
            if ($json === false) {
                return json_encode([
                    "error"   => true,
                    "message" => "Falha ao processar a resposta em JSON.",
                    "data"    => [],
                ]);
            }
            return $json;
        }
    }
