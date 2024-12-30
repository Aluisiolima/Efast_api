<?php
    namespace App\Model;

    use PDOException;
    use PDO;
    class EmpresaModel extends Database
    {
        public static function pegarEmpresa(): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "SELECT * FROM empresa WHERE status = 'ativa';";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $resultado;
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        public static function inserirEmpresa(array $data): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "INSERT INTO empresa (nome_empresa,endereco,whatsapp,instagram,facebook,email,logo_img) VALUES (?,?,?,?,?,?,?);";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["nome"],
                    $data["endereco"],
                    $data["whastapp"],
                    $data["instagram"],
                    $data["facebook"],  
                    $data["email"],
                    $data["logo"],
                ]);

                return [
                    "messagem" => "Empresa inserida com sucesso !!"
                ];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        public static function updateEmpresa(array $data, int $id): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "UPDATE empresa SET 
                                nome_empresa = ?,
                                endereco = ?,
                                whatsapp = ?,
                                instagram = ?,
                                facebook = ?,
                                email = ?, 
                                logo_img = ?
                                WHERE id_empresa = ?;";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["nome"],
                    $data["endereco"],
                    $data["whastapp"],
                    $data["instagram"],
                    $data["facebook"],  
                    $data["email"],
                    $data["logo"],
                    $id
                ]);

                return [
                    "messagem" => "Empresa atualizada com sucesso !!"
                ];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        public static function desativaEmpresa(array $data): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "UPDATE empresa SET status = 'desativada' WHERE id_empresa = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["id"]
                ]);

                return [
                    "messagem" => "Empresa desativada com sucesso !!"
                ];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        public static function ativaEmpresa(array $data): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "UPDATE empresa SET status = 'ativa' WHERE id_empresa = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["id"]
                ]);

                return [
                    "messagem" => "Empresa ativada com sucesso !!"
                ];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }
    }