<?php
    namespace App\Model;

    use App\Validations\ProdutosValidate\NewProdutos;
    use App\Validations\ProdutosValidate\UpdateProdutos;
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
         * @param int $id sendo o id da empresa que voce que os produtos
         * @return array
         */
        public function pegarProdutos(int $id): array
        {
            try {
                $pdo = $this->getConnection();
                $sql = "SELECT 
                            p.id_produto,
                            p.nome_produto,
                            p.valor,
                            p.tipo,
                            a.path,
                            p.desconto
                        FROM produtos p
                        JOIN empresa e ON e.id_empresa = p.id_empresa
                        JOIN arquivo a ON a.id_arquivo = p.id_img
                        WHERE p.id_empresa = ? AND p.status = 'ativo' AND e.status = 'ativa'
                        ORDER BY p.tipo;";
                    
                $stmt = $pdo->prepare($sql);
                
                $stmt->execute([$id]);
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } finally {
                $pdo = null;
            }
        }

        public function getTypes(int $id): array
        {
            try {
                $pdo = $this->getConnection();
                $sql ="SELECT tipo FROM produtos WHERE id_empresa = ? AND status = 'ativo' GROUP BY tipo";
                    
                $stmt = $pdo->prepare($sql);
                
                $stmt->execute([$id]);
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } finally {
                $pdo = null;
            }
        }

        /**
         * Pegar os registro de produtos que tem seu status Ativo
         * @param int $id sendo o id do produto
         * @return array
         */
        public function pegarProdutosUnico(int $id): array
        {
            try {
                $pdo = $this->getConnection();
                $sql = "SELECT 
                            p.id_produto,
                            p.nome_produto,
                            p.valor,
                            p.tipo,
                            a.path,
                            p.desconto,
                            p.descricao
                        FROM produtos p
                        JOIN empresa e ON e.id_empresa = p.id_empresa
                        JOIN arquivo a ON a.id_arquivo = p.id_img
                        WHERE p.id_produto = ? AND e.status = 'ativa'
                        ORDER BY p.tipo;";
                    
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
         * Pegar os produtos cargo chefe da empresa
         * @param int $id sendo o id da empresa que voce que os produtos
         * @return array
         */
        public function pegarProdutosMain(int $id): array
        {
            try {
                $pdo = $this->getConnection();
                $sql = "SELECT tipo FROM produtos WHERE id_empresa = ? AND status = 'ativo' GROUP BY tipo ORDER BY  count(*) desc limit 3";
                    
                $stmt = $pdo->prepare($sql);
                
                $stmt->execute([$id]);
    
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } finally {
                $pdo = null;
            }
        }

        /**
         * Inserir os dados de novo produto
         * @param NewProdutos $data 
         * @return array
         */
        public function inseriProdutos(NewProdutos $data, int $id_empresa): array
        {
            try {
                $pdo = $this->getConnection();
                $sql = "INSERT INTO produtos (nome_produto, valor, tipo, id_img, id_empresa, desconto, descricao) VALUES (?,?,?,?,?,?);";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data->nome,
                    $data->valor,
                    $data->tipo,
                    $data->id_img,
                    $id_empresa,
                    $data->desconto,
                    $data->descricao
                ]);
    
                return [
                    "message"   => "Produto inserido com sucesso",
                ];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } finally {
                $pdo = null;
            }
        }
        
        /**
         * Editar os dados dos produto
         * @param UpdateProdutos $data 
         * @return array
         */
        public function updateProdutos(UpdateProdutos $data, int $id_empresa): array
        {
            try {
                $pdo = $this->getConnection();
                $sql = "UPDATE produtos 
                            SET nome_produto = COALESCE(?, nome_produto), 
                                valor = COALESCE(?, valor),
                                tipo = COALESCE(?, tipo),
                                id_img = COALESCE(?, id_img),
                                desconto = COALESCE(?, desconto),
                                descricao = COALESCE(?, descricao)
                            WHERE id_produto = ? AND id_empresa = ?";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data->nome,
                    $data->valor,
                    $data->tipo,
                    $data->id_img,
                    $data->desconto,
                    $data->id,
                    $data->descricao,
                    $id_empresa
                ]);
                
                return [
                    "message"=> "sucesso em edita o produto",
                ];
            }catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            } finally {
                $pdo = null;
            }
        }

        /**
         * Desativa o produto para nao ser comecializado
         * @param int $id sendo o id do produto 
         * @return array
         */
        public function desativaProdutos(int $id, int $id_empresa): array
        {
            try {
                $pdo = $this->getConnection();
                $sql = "UPDATE produtos SET status = 'desativado' WHERE id_produto = ? AND id_empresa = ?;";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $id,
                    $id_empresa,
                ]);

                return [
                    "message"=> "sucesso em desativa o produto",
                ];
            }catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            } finally {
                $pdo = null;
            }
        }

        /**
         * Ativa o produto para ser comecializado
         * @param int $id sendo o id do produto
         * @return array
         */
        public function ativaProdutos(int $id, int $id_empresa): array
        {
            try {
                $pdo = $this->getConnection();
                $sql = "UPDATE produtos SET status = 'ativo' WHERE id_produto = ? AND id_empresa = ?;";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $id,
                    $id_empresa
                ]);

                return [
                    "message"=> "sucesso em ativa o produto",
                ];
            }catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            } finally {
                $pdo = null;
            }
        }
    }
