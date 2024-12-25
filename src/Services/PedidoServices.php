<?php
    namespace App\Services;

    use App\Model\PedidoModel;
    use App\Utils\Validator;
    use Exception;
    use PDOException;

    class PedidoServices
    {
        public static function inserirPedido(array $data): array
        {
            try {
                $fields = Validator::validatePedido([
                    "nome"          => $data["nome"],
                    "tipo_pagamento"=> $data["tipo_pagamento"],
                    "numero_contato"=> $data["numero_contato"],
                    "entrega"       => $data["entrega"],
                    "bairro"        => $data["bairro"],
                    "rua"           => $data["rua"],
                    "numero_casa"   => $data["numero_casa"],
                    "mesa"          => $data["mesa"],
                    "numero_mesa"   => $data["numero_mesa"],
                ]);

                $fields["data"] = self::data();
    
                $pedidos = PedidoModel::pegarPedido($fields);
                return  $pedidos;
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
            
        }

        private static function data(): string
        {
            date_default_timezone_set('America/Sao_Paulo'); // Ajuste conforme sua região

            // Obtém a data e hora atual em formato separado
            $dia = date('d');     // Dia do mês
            $mes = date('m');     // Mês
            $ano = date('Y');     // Ano
            $hora = date('H');    // Hora
            $minuto = date('i');  // Minuto
            
            return "$dia/$mes/$ano $hora:$minuto";
        }
    
    }
