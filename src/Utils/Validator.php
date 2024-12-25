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
                    throw new Exception("O campo {$value} é obrigatorio!!");
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