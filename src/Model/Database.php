<?php
    namespace App\Model;

    use PDO;
    use PDOException;

    /**
     * Class Database
     * 
     * Esta classe é responsável por gerenciar a conexão com o banco de dados.
     */
    class Database 
    {   
        /**
         * Obtém uma conexão com o banco de dados.
         * 
         * @return PDO|null Retorna uma instância de PDO em caso de sucesso ou null em caso de erro.
         */
        protected function getConnection()
        {
            try {
                // Cria uma nova instância de PDO com os parâmetros do ambiente
                $pdo = new PDO(
                    "mysql:host=" . $_ENV['DB_HOST'] . ";port=" . $_ENV['DB_PORT'] . ";dbname=" . $_ENV['DB_NAME'], 
                    $_ENV['DB_USER'], 
                    $_ENV['DB_PASSWORD']
                );

                // Configura o modo de erro para exceções
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                return $pdo;

            } catch (PDOException $e) {
                // Exibe uma mensagem de erro em caso de falha na conexão
                echo "Erro na conexão: " . $e->getMessage();
            }
        }
    }
