<?php
    namespace App\Utils;

    use App\Http\Resquest;

    class Logs
    {
        private static float $timeStart = 0;
        public static function log_request(): void 
        {   
            $dataHora = date('Y-m-d H:i:s');
            self::$timeStart = microtime(true);

            $metodo = Resquest::method();
            $uri = $_GET["url"] ?? "/";

            $mensagemLog = "**[$dataHora]** **$metodo** __ $uri __  " . PHP_EOL;
            self::seedLog($mensagemLog);
        }

        public static function log_response(int $statusCode): void 
        {
            $dataHora = date('Y-m-d H:i:s');
            $tempoExecucao = (microtime(true) - self::$timeStart) * 1000;

            $mensagemLog = "**[$dataHora]** | Resposta: **$statusCode** | Tempo de execução: __".number_format($tempoExecucao, 2)."ms__" . PHP_EOL;

            self::seedLog($mensagemLog);
        }

        private static function seedLog(string $mensagem): void
        {
            $webhookUrl = $_ENV['LOG_URL'];

            $ch = curl_init($webhookUrl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( ['content' => $mensagem]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            curl_exec($ch);
            curl_close($ch);
        }
    }
    
