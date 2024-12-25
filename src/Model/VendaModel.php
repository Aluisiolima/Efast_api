<?php 
    namespace App\Model;

    use PDO;
    use PDOException;

    class VendaModel extends Database
    {
        public static function pegarVendas(array $data): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "SELECT * FROM venda WHERE id_empresa = ?;";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["id_empresa"]
                ]);

                $vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $vendas;
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
            
        }
    }