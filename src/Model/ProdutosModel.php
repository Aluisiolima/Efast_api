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
            try {
                $pdo = self::getConnection();
                $sql = "SELECT 
                            p.id_produto,
                            p.nome_produto,
                            p.valor,
                            p.tipo,
                            a.path
                        FROM produtos p
                        JOIN empresa e ON e.id_empresa = p.id_empresa
                        JOIN arquivo a ON a.id_arquivo = p.id_img
                        WHERE p.id_empresa = ? AND p.status = 'ativo' AND e.status = 'ativa'
                        ORDER BY p.tipo;";
                    
                $stmt = $pdo->prepare($sql);
                
                $stmt->execute([$data["id_empresa"]]);
    
                $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                return $produtos;
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }
        /**
         * Pegar os produtos cargo chefe da empresa
         * @param array $data contendo as chave
         *  - "id_empresa" : INT sendo o id da empressa qual o produto e relacionado 
         * @return array
         */
        public static function pegarProdutosMain(array $data): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "SELECT tipo FROM produtos WHERE id_empresa = ? AND status = 'ativo' GROUP BY tipo ORDER BY  count(*) desc limit 3";
                    
                $stmt = $pdo->prepare($sql);
                
                $stmt->execute([$data["id_empresa"]]);
    
                $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
                return $produtos;
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
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
        public static function inseriProdutos(array $data, int $id_empresa): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "INSERT INTO produtos (nome_produto, valor, tipo, id_img, id_empresa, desconto) VALUES (?,?,?,?,?,?);";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["nome"],
                    $data["valor"],
                    $data["tipo"],
                    $data["id_img"],
                    $id_empresa,
                    $data["desconto"]
                ]);
    
                return [
                    "message"   => "Produto inserido com sucesso",
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
        public static function updateProdutos(array $data, int $id_empresa): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "UPDATE produtos 
                            SET nome_produto = ?, 
                                valor = ?,
                                tipo = ?,
                                id_img = ?
                            WHERE id_produto = ? AND id_empresa = ?";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["nome"],
                    $data["valor"],
                    $data["tipo"],
                    $data["id_img"],
                    $data["id"],
                    $id_empresa
                ]);
                
                return [
                    "message"=> "sucesso em edita o produto",
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
        public static function desativaProdutos(array $data, int $id_empresa): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "UPDATE produtos SET status = 'desativado' WHERE id_produto = ? AND id_empresa = ?;";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["id"],
                    $id_empresa,
                ]);

                return [
                    "message"=> "sucesso em desativa o produto",
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
        public static function ativaProdutos(array $data, int $id_empresa): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "UPDATE produtos SET status = 'ativo' WHERE id_produto = ? AND id_empresa = ?;";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["id"],
                    $id_empresa
                ]);

                return [
                    "message"=> "sucesso em ativa o produto",
                ];
            }catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
        }

    }