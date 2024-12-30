<?php
    namespace App\Utils;

    use App\Http\Resquest;
    use Exception;

    class Logs
    {
        public static function Log(array $dates, int $status) 
        {
            $dir = "logs/";
            date_default_timezone_set('America/Sao_Paulo');
            $dataHora = date('Y-m-d H:i:s');

            if (!is_dir($dir)) {
                if (!mkdir($dir, 0755, true)) {
                    throw new Exception("Falha ao criar o diretório de upload: {$dir}");
                }
            } 
            
            // Verifica se o diretório tem permissão de gravação
            if (!is_writable($dir)) {
                throw new Exception("O diretório de upload não tem permissão de gravação: {$dir}");
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
    
