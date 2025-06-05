<?php
    namespace App\Model;

    use App\Validations\EmpresaValidate\NewEmpresa;
    use App\Validations\EmpresaValidate\UpdateEmpresa;
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
        public function pegarEmpresa(): array
        {
            try {
                $pdo = $this->getConnection();
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
            } finally {
                $pdo = null;
            }
        }
        /**
         * Obtém a empresas ativas pedida pelo usuario.
         *
         * @param int $id id da empresa 
         * @return array Lista de empresas ou mensagem de erro.
         */
        public function pegarEmpresaOne(int $id): array
        {
            try {
                $pdo = $this->getConnection();
                $sql = "SELECT 
                            e.id_empresa,
                            e.nome_empresa,
                            e.whatsapp,
                            e.instagram,
                            e.facebook,
                            e.endereco,
                            e.email,
                            a.path,
                            e.logo_img
                        FROM empresa e 
                        JOIN arquivo a ON a.id_arquivo = e.logo_img
                        WHERE e.id_empresa = ? AND e.status = 'ativa';";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);

                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } finally {
                $pdo = null;
            }
        }

        /**
         * Insere uma nova empresa no banco de dados.
         *
         * @param NewEmpresa $data Dados da empresa a ser inserida.
         * @return array Mensagem de sucesso ou erro.
         */
        public function inserirEmpresa(NewEmpresa $data): array
        {
            try {
                $pdo = $this->getConnection();
                $sql = "INSERT INTO empresa (nome_empresa, endereco, whatsapp, instagram, facebook, email, logo_img) VALUES (?,?,?,?,?,?,1);";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data->nome,
                    $data->endereco,
                    $data->whastapp,
                    $data->instagram,
                    $data->facebook,  
                    $data->email,
                ]);

                return ["messagem" => "Empresa inserida com sucesso !!"];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } finally {
                $pdo = null;
            }
        }

        /**
         * Atualiza os dados de uma empresa específica.
         *
         * @param UpdateEmpresa $data Dados atualizados da empresa.
         * @param int $id ID da empresa a ser atualizada.
         * @return array Mensagem de sucesso ou erro.
         */
        public function updateEmpresa(UpdateEmpresa $data, int $id): array
        {
            try {
                $pdo = $this->getConnection();
                $sql = "UPDATE empresa SET 
                            nome_empresa = COALESCE(?, nome_empresa),
                            endereco = COALESCE(?, endereco),
                            whatsapp = COALESCE(?, whatsapp),
                            instagram = COALESCE(?, instagram),
                            facebook = COALESCE(?, facebook),
                            email = COALESCE(?, email), 
                            logo_img = COALESCE(?, logo_img)
                        WHERE id_empresa = ?;";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data->nome,
                    $data->endereco,
                    $data->whastapp,
                    $data->instagram,
                    $data->facebook,  
                    $data->email,
                    $data->logo,
                    $id
                ]);

                return ["messagem" => "Empresa atualizada com sucesso !!"];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } finally {
                $pdo = null;
            }
        }

        /**
         * Desativa uma empresa específica.
         *
         * @param int $id ID da empresa.
         * @return array Mensagem de sucesso ou erro.
         */
        public function desativaEmpresa(int $id): array
        {
            try {
                $pdo = $this->getConnection();
                $sql = "UPDATE empresa SET status = 'desativada' WHERE id_empresa = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);

                return ["messagem" => "Empresa desativada com sucesso !!"];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } finally {
                $pdo = null;
            }
        }

        /**
         * Ativa uma empresa específica.
         *
         * @param int $id ID da empresa.
         * @return array Mensagem de sucesso ou erro.
         */
        public function ativaEmpresa(int $id): array
        {
            try {
                $pdo = $this->getConnection();
                $sql = "UPDATE empresa SET status = 'ativa' WHERE id_empresa = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);

                return ["messagem" => "Empresa ativada com sucesso !!"];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } finally {
                $pdo = null;
            }
        }
    }
