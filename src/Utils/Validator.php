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
        
                if (!array_key_exists("id", $item) || !array_key_exists("quantidade", $item)) {
                    throw new Exception("As chave {id && quantidade && desconto_aplicado} sao obrigatorias.");
                }
        
                if (($item["id"] === null || !is_int($item["id"]))|| ($item["quantidade"] === null || !is_int($item["quantidade"]))) {
                    throw new Exception("As chave {id && quantidade } estao vazias ou seu valores sao diferente (int).");
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
            $maxSize = 12 * 1024 * 1024; // 12MB
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $targetDir = "../uploads/{$subPath}/";

            // 🔍 Valida se o arquivo foi enviado corretamente
            if (empty($dates['tmp_name']) || !file_exists($dates['tmp_name'])) {
                throw new Exception("Arquivo inválido ou não enviado.");
            }

            // 🔍 Verifica se é uma imagem válida
            $imageInfo = getimagesize($dates['tmp_name']);
            if ($imageInfo === false) {
                throw new Exception("O arquivo enviado não é uma imagem válida.");
            }

            // 🔍 Verifica o tamanho do arquivo
            if (empty($dates['size']) || $dates['size'] > $maxSize) {
                throw new Exception("O arquivo é muito grande. Tamanho máximo permitido: 12MB.");
            }

            // 🔍 Verifica a extensão
            $fileExtension = strtolower(pathinfo($dates['name'], PATHINFO_EXTENSION));
            if (!in_array($fileExtension, $allowedExtensions)) {
                throw new Exception("Tipo de arquivo não permitido. Permitidos: JPG, JPEG, PNG e GIF.");
            }

            // 🗂️ Garante que o diretório existe
            if (!is_dir($targetDir) && !mkdir($targetDir, 0777, true)) {
                throw new Exception("Falha ao criar o diretório de upload: {$targetDir}");
            }

            // 🔐 Verifica permissões de escrita no diretório
            if (!is_writable($targetDir)) {
                throw new Exception("O diretório de upload não tem permissão de gravação.");
            }

            // 📦 Verifica espaço no diretório (função própria)
            if (!self::verifica_diretorio($targetDir)) {
                throw new Exception("Sem espaço disponível no diretório de arquivos.");
            }

            // 🏷️ Gera um nome único para o arquivo, evitando sobrescrever
            $safeFileName = uniqid('img_', true) . '.' . $fileExtension;
            $targetFile = $targetDir . $safeFileName;

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