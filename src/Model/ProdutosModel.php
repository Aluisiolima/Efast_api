<?php
    namespace App\Model;
    use PDO;
use PDOException;

    class ProdutosModel extends Database
    {
        public static function pegarProdutos(array $data): array
        {
            $pdo = self::getConnection();
            $sql = "SELECT * FROM produtos WHERE id_empresa = ? AND status = 'ativo';";
                
            $stmt = $pdo->prepare($sql);
            
            $stmt->execute([$data["id_empresa"]]);

            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $produtos;
           
        }
        public static function inseriProdutos(array $data): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "INSERT INTO produtos (nome_produto, valor, tipo, id_img, id_empresa) VALUES (?,?,?,?,?);";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["nome"],
                    $data["valor"],
                    $data["tipo"],
                    $data["id_img"],
                    $data["id_empresa"]
                ]);
    
                return [
                    "message"   => "Produto inserido com sucesso",
                    "dados"     => $data,
                ];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
           
        }
        public static function desativaProdutos(array $data): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "UPDATE produtos SET status = 'desativado' WHERE id_produto = ?;";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["id"],
                ]);

                return [
                    "message"=> "sucesso em desativa o produto",
                    "dados"=> $data
                ];
            }catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
        }
        public static function updateProdutos(array $data): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "UPDATE produtos 
                            SET nome_produto = ?, 
                                valor = ?,
                                tipo = ?,
                                id_img = ?
                            WHERE id_produto = ?";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["nome"],
                    $data["valor"],
                    $data["tipo"],
                    $data["id_img"],
                    $data["id"],
                ]);
                
                return [
                    "message"=> "sucesso em edita o produto",
                    "dados"=> $data
                ];
            }catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
        }

    }