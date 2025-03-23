<?php
    namespace App\Services;

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
    class EmpresaServices
    {
        /**
         * Obtém as empresas ativas do banco de dados.
         *
         * @return array Lista de empresas ou mensagem de erro.
         */
        public static function pegarEmpresa(): array
        {
            try {
                return EmpresaModel::pegarEmpresa();
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
        public static function pegarEmpresaOne(int $id): array
        {
            try {
                return EmpresaModel::pegarEmpresaOne($id);
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
        public static function inserirEmpresa(array $data, mixed $auth): array
        {
            try {
                if (isset($auth["error"])) {
                    return ["unauthorized" => $auth["error"]];
                }

                $token = JWToken::validateToken($auth);
                if (!$token) return ["unauthorized" => "Você não está autorizado a essa operação. Faça login."];

                
                
                if ($token->cargo !== "dev") {
                    return ["error" => "Você não tem autorização para atualizar esta empresa."];
                }
                
                return EmpresaModel::inserirEmpresa(new NewEmpresa($data));
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
        public static function updateEmpresa(array $data, mixed $auth): array
        {
            try {
                if (isset($auth["error"])) {
                    return ["unauthorized" => $auth["error"]];
                }

                $token = JWToken::validateToken($auth);
                if (!$token) return ["unauthorized" => "Você não está autorizado a essa operação. Faça login."];

                if ($token->cargo !== "empresario") {
                    return ["error" => "Você não tem autorização para atualizar esta empresa."];
                }

                return EmpresaModel::updateEmpresa(new UpdateEmpresa($data), $token->id_empresa);
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
        public static function desativaEmpresa(array $data, mixed $auth): array
        {
            try {
                if (isset($auth["error"])) {
                    return ["unauthorized" => $auth["error"]];
                }

                $token = JWToken::validateToken($auth);
                if (!$token) return ["unauthorized" => "Você não está autorizado a essa operação. Faça login."];

                $fields = Validator::validateArray([
                    "id" => $data["id"] ?? "",
                ]);

                if ($token->cargo !== "dev") {
                    return ["error" => "Você não tem autorização para desativar esta empresa."];
                }

                return EmpresaModel::desativaEmpresa($fields);
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
        public static function ativaEmpresa(array $data, mixed $auth): array
        {
            try {
                if (isset($auth["error"])) {
                    return ["unauthorized" => $auth["error"]];
                }

                $token = JWToken::validateToken($auth);
                if (!$token) return ["unauthorized" => "Você não está autorizado a essa operação. Faça login."];

                $fields = Validator::validateArray([
                    "id" => $data["id"] ?? "",
                ]);

                if ($token->cargo !== "dev") {
                    return ["error" => "Você não tem autorização para ativar esta empresa."];
                }

                return EmpresaModel::ativaEmpresa($fields);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
        }
    }
