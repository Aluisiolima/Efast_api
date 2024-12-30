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
        public static function inserirArquivo(string $path, int $id_empresa): array
        {
            try {
                $pdo = self::getConnection();

                $pdo->beginTransaction();
                
                $sql = "INSERT INTO arquivo (tipo,path,id_empresa) VALUES (?,?,?);";
                $stmt = $pdo->prepare($sql);

                $stmt->execute([
                    "imagem",
                    $path,
                    $id_empresa
                ]);

                $id = $pdo->lastInsertId();
                $pdo->commit();

                return [
                    "message" => "Arquivo de Imagem Inserida com Sucesso!!!",
                    "id" => $id
                ];
            } catch (PDOException $e) {
                $pdo->rollBack();
                return ["error" => $e->getMessage()];
            }
            
        }
        public static function deleteArquivo(array $data, int $id_empresa): array
        {
            try {
                $pdo = self::getConnection();

                $sql1 = "SELECT path FROM arquivo WHERE id_arquivo = ? AND id_empresa = ?;";
                $stmt1 = $pdo->prepare($sql1);
                $stmt1->execute([
                    $data["id"],
                    $id_empresa 
                ]);
                $result = $stmt1->fetch(PDO::FETCH_ASSOC) ;


                $sql = "DELETE FROM arquivo WHERE id_arquivo = ? AND id_empresa = ?;";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["id"],
                    $id_empresa,
                ]);

                
                return $result;
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
            
        }
    }