<?php
    namespace App\Model;

    use PDO;
    use PDOException;

    class PedidoModel extends Database
    {
        public static function pegarPedido(array $data): array
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

                $pdo->commit();
                return ["id_pedido" => $pedidos];
            } catch (PDOException $e) {
                $pdo->rollBack();
                return ["error" => $e->getMessage()];
            }
        }
    }
