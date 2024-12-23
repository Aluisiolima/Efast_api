<?php
    namespace App\Model;
    use PDO;
    use PDOException;

    /**
     * Class ProdutosModel 
     * Esta Class é responsável pelas interacoes no banco na table Produtos
     */
    class ProdutosModel extends Database
    {
        /**
         * Pegar os registro de produtos que tem seu status Ativo
         * @param array $data contendo as chaves 
         *  - "id_empresa" : INT sendo o id corresponde da empresa que voce que os produtos  
         * @return array
         */
        public static function pegarProdutos(array $data): array
        {
            $pdo = self::getConnection();
            $sql = "SELECT * FROM produtos WHERE id_empresa = ? AND status = 'ativo';";
                
            $stmt = $pdo->prepare($sql);
            
            $stmt->execute([$data["id_empresa"]]);

            $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $produtos;
           
        }

        /**
         * Inserir os dados de novo produto
         * @param array $data contendo as chaves 
         *  - "nome" : STRIGN sendo o nome do produto 
         *  - "valor" : INT sendo o seu valor de mercado
         *  - "tipo" : STRIGN sendo sua tipagem
         *  - "id_img" : INT sendo o id do seu arquivo de img para layout
         *  - "id_empresa" : INT sendo o id da empressa qual o produto e relacionado 
         * @return array
         */
        public static function inseriProdutos(array $data): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "INSERT INTO produtos (nome_produto, valor, tipo, id_img, id_empresa) VALUES (?,?,?,?,?);";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["nome"],
                    $data["valor"],
                    $data["tipo"],
                    $data["id_img"],
                    $data["id_empresa"]
                ]);
    
                return [
                    "message"   => "Produto inserido com sucesso",
                    "dados"     => $data,
                ];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
           
        }
        
        /**
         * Editar os dados dos produto
         * @param array $data contendo as chaves 
         *  - "nome" : STRIGN sendo o nome do produto 
         *  - "valor" : INT sendo o seu valor de mercado
         *  - "tipo" : STRIGN sendo sua tipagem
         *  - "id_img" : INT sendo o id do seu arquivo de img para layout
         *  - "id" : INT sendo o id do produto qual o voce que edit 
         * @return array
         */
        public static function updateProdutos(array $data): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "UPDATE produtos 
                            SET nome_produto = ?, 
                                valor = ?,
                                tipo = ?,
                                id_img = ?
                            WHERE id_produto = ?";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["nome"],
                    $data["valor"],
                    $data["tipo"],
                    $data["id_img"],
                    $data["id"],
                ]);
                
                return [
                    "message"=> "sucesso em edita o produto",
                    "dados"=> $data
                ];
            }catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
        }

        /**
         * Desativa o produto para nao ser comecializado
         * @param array $data contendo as chaves 
         *  - "id" : INT sendo o id do produto 
         * @return array
         */
        public static function desativaProdutos(array $data): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "UPDATE produtos SET status = 'desativado' WHERE id_produto = ?;";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["id"],
                ]);

                return [
                    "message"=> "sucesso em desativa o produto",
                    "dados"=> $data
                ];
            }catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
        }

        /**
         * Ativa o produto para ser comecializado
         * @param array $data contendo as chaves 
         *  - "id" : INT sendo o id do produto 
         * @return array
         */
        public static function ativaProdutos(array $data): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "UPDATE produtos SET status = 'ativo' WHERE id_produto = ?;";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["id"],
                ]);

                return [
                    "message"=> "sucesso em ativa o produto",
                    "dados"=> $data
                ];
            }catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
        }

    }