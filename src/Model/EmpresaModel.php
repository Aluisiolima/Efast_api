<?php
    namespace App\Model;

    use PDOException;
    use PDO;

    /**
     * Classe EmpresaModel
     *
     * Gerencia operações de banco de dados relacionadas à tabela "empresa".
     */
    class EmpresaModel extends Database
    {
        /**
         * Obtém todas as empresas ativas.
         *
         * @return array Lista de empresas ou mensagem de erro.
         */
        public static function pegarEmpresa(): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "SELECT 
                            e.id_empresa,
                            e.nome_empresa,
                            e.whatsapp,
                            e.instagram,
                            e.facebook,
                            e.endereco,
                            e.email,
                            a.path
                        FROM empresa e 
                        JOIN arquivo a ON a.id_arquivo = e.logo_img
                        WHERE status = 'ativa';";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        /**
         * Insere uma nova empresa no banco de dados.
         *
         * @param array $data Dados da empresa a ser inserida.
         * @return array Mensagem de sucesso ou erro.
         */
        public static function inserirEmpresa(array $data): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "INSERT INTO empresa (nome_empresa, endereco, whatsapp, instagram, facebook, email, logo_img) VALUES (?,?,?,?,?,?,?);";
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

                return ["messagem" => "Empresa inserida com sucesso !!"];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        /**
         * Atualiza os dados de uma empresa específica.
         *
         * @param array $data Dados atualizados da empresa.
         * @param int $id ID da empresa a ser atualizada.
         * @return array Mensagem de sucesso ou erro.
         */
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

                return ["messagem" => "Empresa atualizada com sucesso !!"];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        /**
         * Desativa uma empresa específica.
         *
         * @param array $data Dados contendo o ID da empresa.
         * @return array Mensagem de sucesso ou erro.
         */
        public static function desativaEmpresa(array $data): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "UPDATE empresa SET status = 'desativada' WHERE id_empresa = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$data["id"]]);

                return ["messagem" => "Empresa desativada com sucesso !!"];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        /**
         * Ativa uma empresa específica.
         *
         * @param array $data Dados contendo o ID da empresa.
         * @return array Mensagem de sucesso ou erro.
         */
        public static function ativaEmpresa(array $data): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "UPDATE empresa SET status = 'ativa' WHERE id_empresa = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$data["id"]]);

                return ["messagem" => "Empresa ativada com sucesso !!"];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }
    }
