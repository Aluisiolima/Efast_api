<?php
    namespace App\Services;

    use App\Model\VendaModel;
    use Exception;
    use PDOException;
    use App\Http\JWToken;

    /**
     * Classe VendaServices
     * Responsavel pela interacoes de vendas feitas pela empresa relacionada
     */
    class VendaServices extends ServicesBase
    {
        public function __construct(
            private readonly VendaModel $vendaModel,
            private readonly JWToken $jwToken
        ) {
            parent::__construct($jwToken);
        }
        
        /**
         * Responsavel por pegas todas as vendas da empresa
         * @param array $data
         * @return array
         */
        public function pegarVendas(mixed $auth): array
        {
            try{
                $token = $this->verificaToken($auth);
                $vendasModel = $this->vendaModel->pegarVendas($token->id_empresa);

                return $this->modelagemDate($vendasModel); 
            } catch(Exception $e) {
                return ["error" => $e->getMessage()];
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
        }
        
        /**
         * Responsavel por pegas todas as venda de hoje
         * @param array $data
         * @return array
         */
        public function pegarVendasDay(mixed $auth): array
        {
            try{
                $token = $this->verificaToken($auth);
                date_default_timezone_set("America/Sao_Paulo");
                $day  = date("d/m/Y");

                $vendasModel = $this->vendaModel->pegarVendasDay($token->id_empresa, $day);
                return $this->modelagemDate($vendasModel);
            } catch(Exception $e) {
                return ["error" => $e->getMessage()];
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
        }
        
        /**
         * Responsavel por modela a respotas em um formato mais adquado
         * @param array $data
         * @return array
         */
        private function modelagemDate(array $data): array
        {
            try{
                $vendasAgrupadas = [];

                foreach ($data as $row) {
                    $idPedido = $row["id_pedido"];

                    // Verifica se o pedido já existe no array
                    if (!isset($vendasAgrupadas[$idPedido])) {
                        $vendasAgrupadas[$idPedido] = [
                            "id" => $row["id_pedido"],
                            "cliente" => $row["nome_cliente"],
                            "tipo_pagamento" => $row["tipo_pagamento"],
                            "endereco" => !empty($row["bairro"]) ? "{$row["rua"]}, {$row["bairro"]}, Nº {$row["numero_casa"]}" : "Estabelecimento",
                            "mesa" => !empty($row["mesa"]) ? "Mesa {$row["numero_mesa"]}" : "Delivery",
                            "data_pedido" => $row["data_pedido"],
                            "contato" => $row["numero_contato"],
                            "status" => $row["status"],
                            "produtos" => [],
                            "t_frete" => $row["t_frete"],
                            "valor_total" => 0
                        ];
                    }

                    // Adiciona os produtos ao pedido
                    $vendasAgrupadas[$idPedido]["produtos"][] = [
                        "nome_produto" => $row["nome_produto"],
                        "valor" => $row["valor_atual_produto"],
                        "desconto" => $row["desconto_aplicado"],
                        "quantidade" => $row["quantidade"]
                    ];

                    // Atualiza o valor total do pedido
                    $vendasAgrupadas[$idPedido]["valor_total"] += number_format(($row["valor_atual_produto"] * (1 - $row["desconto_aplicado"] / 100)) * $row["quantidade"], 2);
                }

                return array_reverse($vendasAgrupadas);
            } catch(Exception $e) {
                return ["error"=> $e->getMessage()];
            }
        }
    }