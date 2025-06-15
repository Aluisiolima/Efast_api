<?php
    namespace App\Utils;

    use App\Http\Resquest;

    class Logs
    {
        private static float $timeStart = 0;
        private static string $messageLog;

        public static function log_api(int $statusCode): void 
        {   
            $dataHora = date('Y-m-d H:i:s');

            $metodo = Resquest::method();
            $uri = $_GET["url"] ?? "/";

            $dataHora = date('Y-m-d H:i:s');
            $tempoExecucao = (microtime(true) - self::$timeStart) * 1000;

            self::$messageLog = "**[$dataHora]** **$metodo** __ $uri __ | Resposta: **$statusCode** | Tempo de execução: __".number_format($tempoExecucao, 2)."ms__" . PHP_EOL;
            self::seedLog();

        }

        public static function start(): void 
        {
            self::$timeStart = microtime(true);
        }

        private static function seedLog(): void
        {
            $webhookUrl = $_ENV['LOG_URL'];

            $ch = curl_init($webhookUrl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( ['content' => self::$messageLog]));

            // Limita o tempo total de tentativa e conexão
            curl_setopt($ch, CURLOPT_TIMEOUT_MS, 150); // no máximo 150ms de execução
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, 100); // no máximo 100ms para conectar

            // Não se importa com o resultado, só dispara
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);

            @curl_exec($ch);
            
            curl_close($ch);
        }
    }
    
