<?php
    namespace App\Model;

    use PDO;
    use PDOException;

    /**
     * Classe ArquivoModel
     * 
     * Gerencia operações relacionadas aos arquivos armazenados no banco de dados.
     * Extende a classe Database para utilizar a conexão com o banco.
     */
    class ArquivoModel extends Database
    {
        /**
         * Busca arquivos associados a uma empresa específica.
         *
         * @param int $id_empresa ID da empresa cujos arquivos serão buscados.
         * @return array Retorna os arquivos encontrados como um array associativo. 
         * Em caso de erro, retorna um array contendo a mensagem de erro.
         */
        public function pegarArquivo(int $id_empresa): array
        {
            try {
                $pdo = $this->getConnection();
                $sql = "SELECT * FROM arquivo WHERE id_empresa = ?;";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id_empresa]);

                // Recupera os resultados como um array associativo
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $result;
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } finally {
                $pdo = null;
            }
        }

        /**
         * Insere um novo arquivo associado a uma empresa.
         *
         * @param string $path Caminho do arquivo a ser inserido.
         * @param int $id_empresa ID da empresa associada ao arquivo.
         * @return array Retorna uma mensagem de sucesso com o ID do arquivo inserido ou uma mensagem de erro.
         */
        public function inserirArquivo(string $path, int $id_empresa): array
        {
            try {
                $pdo = $this->getConnection();

                // Inicia a transação
                $pdo->beginTransaction();

                $sql = "INSERT INTO arquivo (tipo, path, id_empresa) VALUES (?, ?, ?);";
                $stmt = $pdo->prepare($sql);

                $stmt->execute([
                    "imagem",
                    $path,
                    $id_empresa
                ]);

                // Recupera o ID do último registro inserido
                $id = $pdo->lastInsertId();
                $pdo->commit();

                return [
                    "message" => "Arquivo de Imagem Inserida com Sucesso!!!",
                    "id" => $id
                ];
            } catch (PDOException $e) {
                $pdo->rollBack(); // Reverte a transação em caso de erro
                return ["error" => $e->getMessage()];
            } finally {
                $pdo = null;
            }
        }

        /**
         * Exclui um arquivo associado a uma empresa.
         *
         * @param array $data Dados contendo o ID do arquivo a ser excluído.
         * @param int $id_empresa ID da empresa associada ao arquivo.
         * @return array Retorna o caminho do arquivo excluído ou uma mensagem de erro.
         */
        public function deleteArquivo(int $id, int $id_empresa): array
        {
            try {
                $pdo = $this->getConnection();

                // Busca o caminho do arquivo antes de excluí-lo
                $sql1 = "SELECT path FROM arquivo WHERE id_arquivo = ? AND id_empresa = ?;";
                $stmt1 = $pdo->prepare($sql1);
                $stmt1->execute([
                    $id,
                    $id_empresa 
                ]);
                $result = $stmt1->fetch(PDO::FETCH_ASSOC);

                // Exclui o registro do arquivo
                $sql = "DELETE FROM arquivo WHERE id_arquivo = ? AND id_empresa = ?;";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $id,
                    $id_empresa,
                ]);

                return $result;
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } finally {
                $pdo = null;
            }
        }
    }
