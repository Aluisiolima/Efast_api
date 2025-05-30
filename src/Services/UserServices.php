<?php
    namespace App\Services;

    use App\Model\UserModel;
    use App\Utils\Validator;
    use App\Http\JWToken;
    use Exception;
    use PDOException;

    /**
     * Classe UserServices
     * reponsavel pela interacoes de User Adm da empresa
     */
    class UserServices extends ServicesBase
    {
        public function __construct(
            private readonly UserModel $userModel,
            private readonly JWToken $jwtoken
        ){
            parent::__construct($jwtoken);
        }

        /**
         * Responsavel por pegar os dados de todos os User dessa empresa relacionada
         * @param mixed $auth
         * @return array
         */
        public function pegarUser(mixed $auth):array
        {
            try {
                $token = $this->verificaToken($auth); 
                return $this->userModel->pegarUser($token->id_empresa);
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
            catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
        }

        /**
         * Responsavel por inserir um novo User a empresa
         * @param array $data
         * @param mixed $auth
         * @return array
         */
        public function inserirUser(array $data, mixed $auth):array
        {
            try {
                $token = $this->verificaToken($auth);

                $fields = Validator::validateArray([
                    "nome"      => $data["nome"]        ?? "",
                    "cargo"     => $data["cargo"]       ?? "",
                    "codigo"    => $data["codigo"]      ?? "",
                    "senha"     => $data["senha"]       ?? "",
                ]);

                $fields["senha"] = password_hash($fields['senha'], PASSWORD_DEFAULT);

                $id = ($token->cargo === "dev") ? $data["id"] : $token->id_empresa;

                return $this->userModel->inserirUser($fields, $id);
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
            catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
        }

        
        /**
         * Responsavel por atualiza as informacoes do seu user
         * @param array $data
         * @param mixed $auth
         * @return array
         */
        public function updateUser(array $data, mixed $auth): array
        {
            try {
                $token = $this->verificaToken($auth);

                $fields = Validator::validateArray([
                    "nome" => $data["nome"]  ?? "",
                    "cargo"=> $data["cargo"] ?? "",
                    "senha"=> $data["senha"] ?? "",
                ]);

                $fields["senha"] = password_hash($fields['senha'], PASSWORD_DEFAULT);

                return $this->userModel->updateUser($fields, $token->id);;
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            } catch (Exception $e) {
                return ["error"=> $e->getMessage()];
            }
        }

        /**
         * Responsavel por deleta o seu user
         * @param mixed $auth
         * @return array
         */
        public function deleteUser(mixed $auth): array
        {
            try {
                $token = $this->verificaToken($auth);
                return $this->userModel->deleteUser($token->id, $token->id_empresa);
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            } catch (Exception $e) {
                return ["error"=> $e->getMessage()];
            }
        }
    }