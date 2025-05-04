<?php
    namespace App\Services;

    use App\Interfaces\EmpresaServicesInterface;
    use App\Validations\EmpresaValidate\NewEmpresa;
    use PDOException;
    use Exception;
    use App\Http\JWToken;
    use App\Model\EmpresaModel;
    use App\Utils\Validator;
    use App\Validations\EmpresaValidate\UpdateEmpresa;

    /**
     * Classe EmpresaServices
     *
     * Gerencia as operações de serviços relacionadas às empresas, incluindo autenticação e validação.
     */
    class EmpresaServices extends ServicesBase implements EmpresaServicesInterface 
    {
        public function __construct(
            private readonly EmpresaModel $empresaModel,
            private readonly JWToken $jwToken
        ) {
            parent::__construct($this->jwToken);
        }


        /**
         * Obtém as empresas ativas do banco de dados.
         *
         * @return array Lista de empresas ou mensagem de erro.
         */
        public function pegarEmpresa(): array
        {
            try {
                return $this->empresaModel->pegarEmpresa();
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
        }

        /**
         * Obtém a empresas que o usuario fez a requisicao.
         *
         * @return array Lista de empresas ou mensagem de erro.
         */
        public function pegarEmpresaOne(int $id): array
        {
            try {
                return $this->empresaModel->pegarEmpresaOne($id);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
        }


        /**
         * Insere uma nova empresa no banco de dados, validando o token do usuário.
         *
         * @param array $data Dados da empresa.
         * @param mixed $auth Token de autenticação.
         * @return array Mensagem de sucesso, erro ou autorização.
         */
        public function inserirEmpresa(array $data, mixed $auth): array
        {
            try {
                $token = $this->verificaToken($auth);
                
                if ($token->cargo !== "dev") {
                    return ["error" => "Você não tem autorização para atualizar esta empresa."];
                }
                
                return $this->empresaModel->inserirEmpresa(new NewEmpresa($data));
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
        }

        /**
         * Atualiza os dados de uma empresa no banco de dados.
         *
         * @param array $data Dados da empresa.
         * @param mixed $auth Token de autenticação.
         * @return array Mensagem de sucesso, erro ou autorização.
         */
        public function updateEmpresa(array $data, mixed $auth): array
        {
            try {
                $token = $this->verificaToken($auth);

                if ($token->cargo !== "empresario") {
                    return ["error" => "Você não tem autorização para atualizar esta empresa."];
                }

                return $this->empresaModel->updateEmpresa(new UpdateEmpresa($data), $token->id_empresa);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
        }

        /**
         * Desativa uma empresa no banco de dados.
         *
         * @param array $data Dados contendo o ID da empresa.
         * @param mixed $auth Token de autenticação.
         * @return array Mensagem de sucesso, erro ou autorização.
         */
        public function desativaEmpresa(array $data, mixed $auth): array
        {
            try {
                $token = $this->verificaToken($auth);

                $fields = Validator::validateArray([
                    "id" => $data["id"] ?? "",
                ]);

                if ($token->cargo !== "dev") {
                    return ["error" => "Você não tem autorização para desativar esta empresa."];
                }

                return $this->empresaModel->desativaEmpresa($fields);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
        }

        /**
         * Ativa uma empresa no banco de dados.
         *
         * @param array $data Dados contendo o ID da empresa.
         * @param mixed $auth Token de autenticação.
         * @return array Mensagem de sucesso, erro ou autorização.
         */
        public function ativaEmpresa(array $data, mixed $auth): array
        {
            try {
                $token = $this->verificaToken($auth);
                $fields = Validator::validateArray([
                    "id" => $data["id"] ?? "",
                ]);

                if ($token->cargo !== "dev") {
                    return ["error" => "Você não tem autorização para ativar esta empresa."];
                }

                return $this->empresaModel->ativaEmpresa($fields);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
        }
    }

