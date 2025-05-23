<?php

    namespace App\Model;

    use Exception;
    use PDOException;
    use PDO;

    /**
     * Classe PedidoModel
     * Resposavel pela interacao com os pedidos do banco
     */
    class PedidoModel extends Database
    {
        /**
         * Responsavel por inserir o pedidos e inserir/relaciona os produtos desse pedido
         * @param array $data
         * @param int $id_empresa
         * @return array
         */
        public function inserirPedido(array $data, int $id_empresa): array
        {

            try {
                $pdo = $this->getConnection();

                $pdo->beginTransaction();

                $sql_pedido = "INSERT INTO pedido (nome_cliente,tipo_pagamento ,numero_contato ,entrega ,bairro ,rua ,numero_casa ,mesa ,numero_mesa ,data_pedido, t_frete) VALUES (?,?,?,?,?,?,?,?,?,?,?);";
                $stmt = $pdo->prepare($sql_pedido);
                $stmt->execute([
                    $data["nome"],
                    $data["tipo_pagamento"],
                    $data["numero_contato"],
                    $data["entrega"],
                    $data["bairro"],
                    $data["rua"],
                    $data["numero_casa"],
                    $data["mesa"],
                    $data["numero_mesa"],
                    $data["data"],
                    $data["t_frete"]
                ]);
                $pedidos = $pdo->lastInsertId();

                $sql_venda = "INSERT INTO venda (id_pedido,id_produto,quantidade, id_empresa, desconto_aplicado, valor_atual_produto) VALUES (?,?,?,?,?,?);";
                $stmt_venda = $pdo->prepare($sql_venda);
                
                $sql_produto = "SELECT valor, desconto FROM produtos WHERE id_produto = ?";
                $stmt_produto = $pdo->prepare($sql_produto);

                foreach ($data["produtos"] as $item) {
                    $stmt_produto->execute([$item["id"]]);
            
                    $result = $stmt_produto->fetch(PDO::FETCH_ASSOC);

                    if (!$result) {
                        throw new Exception("Produto com ID {$item['id']} não encontrado.");
                    }

                    [$valor, $desconto] = [$result["valor"], $result["desconto"]];
                    
                    $stmt_venda->execute([
                        $pedidos,
                        $item["id"],
                        $item["quantidade"],
                        $id_empresa,
                        $desconto,
                        $valor,
                    ]);
                }

                $pdo->commit();
                return [
                    "message"   => "sucesso em inserir o pedido"
                ];
            } catch (PDOException $e) {
                $pdo->rollBack();
                return ["error" => $e->getMessage()];
            }catch (Exception $e){
                $pdo->rollBack();
                return ["error" => $e->getMessage()];
            }
            finally {
                $pdo = null;
            }
        }

        public function updateStatus(array $data): array
        {
            try {
                $pdo = $this->getConnection();
                $sql = "UPDATE pedido SET status = ? WHERE id_pedido = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["status"],
                    $data["id"]
                ]);

                return ["messagem" => "status do pedido atualizado sucesso !!"];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } finally {
                $pdo = null;
            }
        }
    }
