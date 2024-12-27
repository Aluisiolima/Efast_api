<?php
    namespace App\Model;

    use PDO;
    use PDOException;

    class PedidoModel extends Database
    {
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

                $sql = "INSERT INTO venda (id_pedido,id_produto,quantidade, id_empresa) VALUES (?,?,?,?);";

                foreach ($data["produtos"] as $item) {
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        $pedidos,
                        $item["id"],
                        $item["quantidade"],
                        $id_empresa
                    ]);
                }

                $pdo->commit();
                return [
                    "message"=> "sucesso em inserir o pedido",
                    "dados"=> $data
                ];
            } catch (PDOException $e) {
                $pdo->rollBack();
                return ["error" => $e->getMessage()];
            }
        }
    }
