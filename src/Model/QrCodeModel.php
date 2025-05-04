<?php   
    namespace App\Model;

    use PDO;
    use PDOException;

    class QrCodeModel extends Database
    {
        /**
         * Verifica se a empresa existe no banco de dados.
         *
         * @param int $id Id da empresa.
         * @return array Mensagem de sucesso ou erro.
         */
        public static function qrcode(int $id): int | array
        {
            try {
                $pdo = self::getConnection();
                $sql = "SELECT id_empresa FROM empresa WHERE id_empresa = ?;";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $id
                ]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if($result){
                    return (int) $result["id_empresa"];
                }
                return ["error" => "not found empresa 404"];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }finally{
                $pdo = null;
            }
        }
    }