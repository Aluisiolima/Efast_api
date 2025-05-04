<?php
    namespace App\Services;

    use App\Http\JWToken;
    use App\Model\ProdutosModel;
    use App\Validations\ProdutosValidate\NewProdutos;
    use App\Validations\ProdutosValidate\UpdateProdutos;
    use Exception;
    use PDOException;

    /**
     * Class ProdutosServices
     * Responsável por gereciar e valida tudo antes de envia pra a model
     */
    class ProdutosServices extends ServicesBase
    {
        public function __construct(
            private readonly ProdutosModel $produtosModel,
            private readonly JWToken $jwToken
        ){
            parent::__construct($this->jwToken);
        }

        /**
         * pega os produtos em banco
         * @param int $id id da empresa 
         * @return array
         */
        public function pegarProdutos(int $id): array
        {
            try { 
                return $this->produtosModel->pegarProdutos($id);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
        }

        public function getTypes(mixed $auth): array
        {
            try {
                $token = $this->verificaToken($auth);
                
                return $this->produtosModel->getTypes($token->id_empresa);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
        }

        /**
         * pega os dados de um produto em banco
         * @param int $id id do produto
         * @return array
         */
        public function pegarProdutosUnico(int $id): array
        {
            try {
                return $this->produtosModel->pegarProdutosUnico($id);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
            
        }

        /**
         * Validar e direciona as informacoes pra inserir os produtos em banco
         * @param array $data 
         * @param mixed $auth 
         * @return array
         */
        public function inseriProdutos(array $data, mixed $auth): array
        {
            try {
                $token = $this->verificaToken($auth);

                return $this->produtosModel->inseriProdutos(new NewProdutos($data), $token->id_empresa);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }catch (Exception $e) {
                return ["error"=> $e->getMessage()];
            }
        }

        /**
         * Validar e direciona as informacoes pra edita os produtos em banco
         * @param array $data 
         * @param mixed $auth 
         * @return array
         */
        public function updateProdutos(array $data, mixed $auth): array
        {
            try {
                $token = $this->verificaToken($auth);

                return $this->produtosModel->updateProdutos(new UpdateProdutos($data), $token->id_empresa);
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            } catch (Exception $e) {
                return ["error"=> $e->getMessage()];
            }
        }

        /**
         * desativa os produtos em banco
         * @param int $id id do produto 
         * @param mixed $auth 
         * @return array
         */
        public function desativaProdutos(int $id, mixed $auth): array
        {
            try {
                $token = $this->verificaToken($auth);

                return $this->produtosModel->desativaProdutos($id, $token->id_empresa);
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            } catch (Exception $e) {
                return ["error"=> $e->getMessage()];
            }
        }

        /**
         * ativa os produtos em banco
         * @param int $id id do produto 
         * @param mixed $auth 
         * @return array
         */
        public function ativaProdutos(int $id, mixed $auth): array
        {
            try {
                $token = $this->verificaToken($auth);

                return $this->produtosModel->ativaprodutos($id, $token->id_empresa);
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            } catch (Exception $e) {
                return ["error"=> $e->getMessage()];
            }
        }

        /**
         * Validar e direciona as informacoes pra pega os produtos principais da em empresa
         * @param int $id id da empresa
         * @return array
         */
        public function pegarProdutosMain(int $id): array
        {
            try {
                return $this->produtosModel->pegarProdutosMain($id);
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            } catch (Exception $e) {
                return ["error"=> $e->getMessage()];
            }
        }
    }
