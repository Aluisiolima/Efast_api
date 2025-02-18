<?php
    namespace App\Model;

    use PDOException;

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
        public static function inserirPedido(array $data, int $id_empresa): array
        {
            
            try {
                $pdo = self::getConnection();

                $pdo->beginTransaction();

                $sql = "INSERT INTO pedido (nome_cliente,tipo_pagamento ,numero_contato ,entrega ,bairro ,rua ,numero_casa ,mesa ,numero_mesa ,data_pedido) VALUES (?,?,?,?,?,?,?,?,?,?);";
                $stmt = $pdo->prepare($sql);
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
                    $data["data"]
                ]);
                $pedidos = $pdo->lastInsertId();

                $sql = "INSERT INTO venda (id_pedido,id_produto,quantidade, id_empresa, desconto_aplicado) VALUES (?,?,?,?,?);";

                foreach ($data["produtos"] as $item) {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        $pedidos,
                        $item["id"],
                        $item["quantidade"],
                        $id_empresa,
                        $item["desconto_aplicado"],
                    ]);
                }

                $pdo->commit();
                return [
                    "message"   => "sucesso em inserir o pedido"
                ];
            } catch (PDOException $e) {
                $pdo->rollBack();
                return ["error" => $e->getMessage()];
            } finally {
                $pdo = null;
            }
        }

        public static function updateStatus(array $data): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "UPDATE pedido SET status = ? WHERE id_pedido = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["status"],
                    $data["id"]
                ]);

                return ["messagem" => "status do pedido atualizado sucesso !!"];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        } 
    }