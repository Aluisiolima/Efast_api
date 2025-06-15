<?php
    namespace App\Http;

    use App\Utils\Logs;
    use Exception;

    /**
     * Class Response
     * 
     * Esta classe é responsável por enviar respostas HTTP.
     */
    class Response
    {
 
        /**
         * Envia uma resposta JSON.
         *
         * @param array $data Dados a serem enviados na resposta.
         * @param int $status Código de status HTTP (default: 200).
         *
         * @return void
         */
        public static function json(array $data = [], int $status = 200): void
        {
            header('Content-Type: application/json');
            http_response_code($status);
            
            echo self::safeJsonEncode($data);
            exit();
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

        public static function files(mixed $file, mixed $type) : void 
        {
            try{
                header('Content-Type: '. $type); 
                header('Content-Disposition: attachment; filename="qrcode.png"'); 

                echo $file;
                exit();
            }catch(Exception $e){
                self::json(["error" => "output file {$e}"],400);
            }
        }
    }
