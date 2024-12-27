<?php
    namespace App\Services;

    use App\Model\VendaModel;
    use App\Utils\Validator;
    use Exception;
    use PDOException;

    class VendaServices
    {
        public static function pegarVendas(array $data): array
        {
            try{
                $fields = Validator::validateArray([
                    "id_empresa" => $data["id"] ?? ""
                ]);

                $vendasModel = VendaModel::pegarVendas($fields);
                $modelagem = self::modelagemDate($vendasModel);
                return $modelagem;
            } catch(Exception $e) {
                return ["error" => $e->getMessage()];
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }

        }
        
        public static function pegarVendasDay(array $data): array
        {
            try{
                $fields = Validator::validateArray([
                    "id_empresa" => $data["id"] ?? ""
                ]);
                
                date_default_timezone_set('America/Sao_Paulo');
                $day  = date('d/m/Y');

                $vendasModel = VendaModel::pegarVendasDay($fields, $day);
                $modelagem = self::modelagemDate($vendasModel);
                return $modelagem;
            } catch(Exception $e) {
                return ["error" => $e->getMessage()];
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }

        }
        
        private static function modelagemDate(array $data): array
        {
            try{
                $vendasAgrupadas = [];

                foreach ($data as $row) {
                    $idPedido = $row['id_pedido'];

                    // Verifica se o pedido já existe no array
                    if (!isset($vendasAgrupadas[$idPedido])) {
                        $vendasAgrupadas[$idPedido] = [
                            'cliente' => $row['nome_cliente'],
                            'tipo_pagamento' => $row['tipo_pagamento'],
                            'endereco' => !empty($row['bairro']) ? "{$row['rua']}, {$row['bairro']}, Nº {$row['numero_casa']}" : 'Estabelecimento',
                            'mesa' => !empty($row['mesa']) ? "Mesa {$row['numero_mesa']}" : "Delivery",
                            'data_pedido' => $row['data_pedido'],
                            'produtos' => [],
                            'valor_total' => 0
                        ];
                    }

                    // Adiciona os produtos ao pedido
                    $vendasAgrupadas[$idPedido]['produtos'][] = [
                        'nome_produto' => $row['nome_produto'],
                        'valor' => $row['valor'],
                        'quantidade' => $row['quantidade']
                    ];

                    // Atualiza o valor total do pedido
                    $vendasAgrupadas[$idPedido]['valor_total'] += ($row['valor'] * $row['quantidade']);
                }

                return $vendasAgrupadas;
            } catch(Exception $e) {
                return ["error"=> $e->getMessage()];
            }
        }
    }