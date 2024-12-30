<?php
    namespace App\Utils;

    use Exception;

    class Validator
    {
        public static function validateArray(array $datas): array
        {
            foreach($datas as $date => $value)
            {
                if(empty(trim((string) $value))){
                    throw new Exception("O campo { $date } e obrigatorio!!");
                }

                $datas[$date] = is_string($value) ? strtolower($value) : $value;
            }
            
            return $datas;
        }

        public static function validatePedido(array $data): array
        {
            // Verificar o campo obrigatório "nome"
            if (!isset($data["nome"]) || empty($data["nome"])) {
                throw new Exception("O campo {nome} e obrigatorio!");
            }

            // Verificar o campo obrigatório "tipo_pagamento"
            if (!isset($data["tipo_pagamento"]) || empty($data["tipo_pagamento"])) {
                throw new Exception("O campo {tipo_pagamento} e obrigatorio!");
            }

            // Verifica se foi enviado os produtos do pedido
            if (!isset($data["produtos"]) || empty($data["produtos"])) {
                throw new Exception("O campo {produtos} e obrigatorio!");
            }

            if (!is_array($data["produtos"])) {
                throw new Exception("O argumento {produtos} precisa ser um array.");
            }
        
            foreach ($data["produtos"] as $item) {
                if (!is_array($item)) {
                    throw new Exception("O argumento {produtos} precisa ser um array de objetos{}.");
                }
        
                if (!array_key_exists("id", $item) || !array_key_exists("quantidade", $item) || !array_key_exists("desconto_aplicado", $item)) {
                    throw new Exception("As chave {id && quantidade && desconto_aplicado} sao obrigatorias.");
                }
        
                if (($item["id"] === null || !is_int($item["id"]))|| ($item["quantidade"] === null || !is_int($item["quantidade"])) || ($item["desconto_aplicado"] === null || !is_int($item["desconto_aplicado"]))) {
                    throw new Exception("As chave {id && quantidade && desconto_aplicado} estao vazias ou seu valores sao diferente (int).");
                }
            }
        
            // Verificar se é um pedido para mesa
            if (isset($data["mesa"]) && $data["mesa"] === true) {
                if (!isset($data["numero_mesa"]) || empty($data["numero_mesa"])) {
                    throw new Exception("O campo {numero_mesa} e obrigatorio para pedidos em mesa!");
                }

                return $data;
            }

            // Verificar se é um pedido para entrega
            if (isset($data["entrega"]) && $data["entrega"] === true) {
                if (!isset($data["bairro"]) || empty($data["bairro"])) {
                    throw new Exception("O campo {bairro} e obrigatorio para pedidos de entrega!");
                }

                if (!isset($data["rua"]) || empty($data["rua"])) {
                    throw new Exception("O campo {rua} e obrigatorio para pedidos de entrega!");
                }

                if (!isset($data["numero_casa"]) || empty($data["numero_casa"])) {
                    throw new Exception("O campo {numero_casa} e obrigatorio para pedidos de entrega!");
                }

                return $data;
            }

            throw new Exception("Falta informacoes para o pedido e nao foi possivel finaliza!!!");
            
        }

        public static function validateImg(array $dates, string $subPath): string
        {
            $maxSize = 12000000;
            $types = ['jpg', 'jpeg', 'png', 'gif'];
            $targetDir = "../uploads/$subPath";

            // Verifica se o arquivo é uma imagem real
            $check = getimagesize($dates['tmp_name']);
            if ($check === false) {
                throw new Exception("O arquivo nao e uma imagem.");
            }

            // Verifica o tamanho do arquivo
            if ($dates['size'] > $maxSize) {
                throw new Exception("O arquivo e muito grande.");
            }

            // Verifica a extensão do arquivo
            $fileExtension = strtolower(pathinfo($dates['name'], PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $types)) {
                throw new Exception("Tipo de arquivo nao permitido. Apenas JPG, JPEG, PNG e GIF sao aceitos.");
            }

            if (!is_dir($targetDir)) {
                if (!mkdir($targetDir, 0777, true)) {
                    throw new Exception("Falha ao criar o diretorio de upload: {$targetDir}");
                }
            } 
            
            // Verifica se o diretório tem permissão de gravação
            if (!is_writable($targetDir)) {
                throw new Exception("O diretorio de upload nao tem permissao de gravacao: {$targetDir}");
            }

            $tamanho = self::verifica_diretorio($targetDir);
            if (!$tamanho){
                throw new Exception("Voce nao tem mais espaco no seu diretorio de arquivos!!!");
            }
            
            $targetFile = $targetDir . basename($dates['name']);
            if (file_exists($targetFile)) {
                throw new Exception("O arquivo já existe.");
            }

            return $targetFile;
        }
        private static function verifica_diretorio(string $diretorio): bool
        {
            $tamanhoTotal = 0;

            // Percorre os arquivos e subdiretórios
            $arquivos = scandir($diretorio);

            foreach ($arquivos as $arquivo) {
                if ($arquivo === '.' || $arquivo === '..') {
                    continue; // Ignora "." e ".."
                }

                $caminho = $diretorio . DIRECTORY_SEPARATOR . $arquivo;

                // Se for arquivo, soma o tamanho; se for diretório, faz recursão
                if (is_file($caminho)) {
                    $tamanhoTotal += filesize($caminho);
                } 

                // Verifica se o tamanho já excede 1 GB durante o cálculo
                if ($tamanhoTotal >= 1 * 1024 * 1024 * 1024) {
                    return false;
                }
            }
            return true;
        }

    }