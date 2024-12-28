<?php
    namespace App\Utils;

    use App\Http\Resquest;


    class Logs
    {
        public static function Log(array $dates, int $status) 
        {
            $dir = "logs/";
            date_default_timezone_set('America/Sao_Paulo');
            $dataHora = date('Y-m-d H:i:s');

            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            // Informações da requisição
            $metodo = Resquest::method();
            $uri = $_GET["url"];
            $dados = json_encode(Resquest::getBody());

            // Informações da resposta
            $resposta = json_encode($dates);

            $mensagemLog = "[$dataHora] $metodo $uri | status: $status | Dados: $dados | Resposta: $resposta" . PHP_EOL;
            $dirFile = "{$dir}api.log";
            // Escreve no log
            file_put_contents($dirFile, $mensagemLog, FILE_APPEND | LOCK_EX);
        }
    }
    
