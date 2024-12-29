<?php
    namespace App\Model;

    use PDO;
    use PDOException;

    class ArquivoModel extends Database
    {
        public static function pegarArquivo(int $id_empresa): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "SELECT * FROM arquivo WHERE id_empresa = ?;";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id_empresa]);

                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                return $result;
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
            
        }

        public static function deleteArquivo(array $data, int $id_empresa): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "DELETE FROM arquivo WHERE id_arquivo = ? AND id_empresa = ?;";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["id"],
                    $id_empresa,
                ]);

                
                return [
                    "message" => "Arquivo deletado com sucesso!!!"
                ];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
            
        }
    }