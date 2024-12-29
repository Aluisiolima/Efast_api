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
                throw new Exception("O campo {nome} é obrigatório!");
            }

            // Verificar o campo obrigatório "tipo_pagamento"
            if (!isset($data["tipo_pagamento"]) || empty($data["tipo_pagamento"])) {
                throw new Exception("O campo {tipo_pagamento} é obrigatório!");
            }

            // Verifica se foi enviado os produtos do pedido
            if (!isset($data["produtos"]) || empty($data["produtos"])) {
                throw new Exception("O campo {produtos} é obrigatório!");
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
                    throw new Exception("O campo {numero_mesa} é obrigatório para pedidos em mesa!");
                }

                return $data;
            }

            // Verificar se é um pedido para entrega
            if (isset($data["entrega"]) && $data["entrega"] === true) {
                if (!isset($data["bairro"]) || empty($data["bairro"])) {
                    throw new Exception("O campo {bairro} é obrigatório para pedidos de entrega!");
                }

                if (!isset($data["rua"]) || empty($data["rua"])) {
                    throw new Exception("O campo {rua} é obrigatório para pedidos de entrega!");
                }

                if (!isset($data["numero_casa"]) || empty($data["numero_casa"])) {
                    throw new Exception("O campo {numero_casa} é obrigatório para pedidos de entrega!");
                }

                return $data;
            }

            throw new Exception("Falta informacoes para o pedido e nao foi possivel finaliza!!!");
            
        }
    }