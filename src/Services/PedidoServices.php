<?php
    namespace App\Services;

    use App\Model\PedidoModel;
    use App\Utils\Validator;
    use Exception;
    use PDOException;


    /**
     * Classe PedidoServices
     * classe responsavel pela interacoes entre os pedidos do cardapio
     */
    class PedidoServices
    {
        /**
         * Validar e direciona as informacoes pra inserir o pedido em banco
         * @param array $data > dados do pedido 
         * @param int $id_empresa > id da empresa relacionada com esse pedido
         * @return array
         */
        public static function inserirPedido(array $data, int $id_empresa): array
        {
            try {
                $fields = Validator::validatePedido([
                    "nome"          => $data["nome"],
                    "tipo_pagamento"=> $data["tipo_pagamento"],
                    "produtos"      => $data["produtos"],
                    "numero_contato"=> $data["numero_contato"],
                    "entrega"       => $data["entrega"],
                    "bairro"        => $data["bairro"],
                    "rua"           => $data["rua"],
                    "numero_casa"   => $data["numero_casa"],
                    "mesa"          => $data["mesa"],
                    "numero_mesa"   => $data["numero_mesa"],
                ]);

                $fields["data"] = self::data();

    
                $pedidoModel = PedidoModel::inserirPedido($fields, $id_empresa);

                return  $pedidoModel;
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
            
        }

        /**
         * Pegar a data e hora exata do pedido para registro
         * @return string 
         */
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
