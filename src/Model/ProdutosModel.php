<?php
    namespace App\Model;
    use PDO;

    class ProdutosModel extends Database
    {
        public static function pegarProdutos(array $data): array
        {
            $pdo = self::getConnection();
            $sql = "SELECT * FROM produtos WHERE id_empressa = ? AND status = 'ativo';";
                
            $stmt = $pdo->prepare($sql);
            
            $stmt->execute([$data["id_empresa"]]);

            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $produtos;
           
        }
    }