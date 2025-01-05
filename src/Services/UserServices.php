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
    class UserServices
    {
        /**
         * Responsavel por pegar os dados de todos os User dessa empresa relacionada
         * @param mixed $auth
         * @return array
         */
        public static function pegarUser(mixed $auth):array
        {
            try {
                if (isset($auth["error"])) {
                    return ["unauthorized" => $auth["error"]];
                }
                $token = JWToken::validateToken($auth);

                if (!$token) return ["unauthorized"=> "Voce nao esta autorizado a essa operacao faca login"];
                
                
                $user = UserModel::pegarUser($token->id_empresa);
                return $user;
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
        public static function inserirUser(array $data, mixed $auth):array
        {
            try {
                if (isset($auth["error"])) {
                    return ["unauthorized" => $auth["error"]];
                }
                $token = JWToken::validateToken($auth);

                if (!$token) return ["unauthorized"=> "Voce nao esta autorizado a essa operacao faca login"];
                

                $fields = Validator::validateArray([
                    "nome"      => $data["nome"]        ?? "",
                    "cargo"     => $data["cargo"]       ?? "",
                    "codigo"    => $data["codigo"]      ?? "",
                    "senha"     => $data["senha"]       ?? "",
                ]);

                $fields["senha"] = password_hash($fields['senha'], PASSWORD_DEFAULT);

                $id = ($token->cargo === "dev") ? $data["id"] : $token->id_empresa;

                $userModel = UserModel::inserirUser($fields, $id);

                return $userModel;
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
            catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
        }

        /**
         * Responsavel por Fazer Login dos User ao entra no app
         * @param array $data
         * @return array
         */
        public static function login(array $data): array
        {
            try {
                $fields = Validator::validateArray([
                    "nome"       => $data["nome"]       ?? "", 
                    "cargo"      => $data["cargo"]      ?? "",
                    "codigo"     => $data["codigo"]     ?? "",
                    "id_empresa" => $data["id_empresa"] ?? "",
                    "senha"      => $data["senha"]      ?? "",
                ]);

                $userModel = UserModel::login($fields);

                if (isset($userModel["error"])) return ["error" => $userModel["error"]];
                
                $token = JWToken::generateToken($userModel);
                return ["token" => $token];
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
            catch (Exception $e) {
                return ["error"=> $e->getMessage()];
            }
        }

        /**
         * Responsavel por atualiza as informacoes do seu user
         * @param array $data
         * @param mixed $auth
         * @return array
         */
        public static function updateUser(array $data, mixed $auth): array
        {
            try {
                if (isset($auth["error"])){
                    return ["unauthorized"=> $auth["error"]];
                }
                $token = JWToken::validateToken($auth);
                if (!$token) return ["unauthorized"=> "Voce nao esta autorizado a essa operacao faca login"];

                $fields = Validator::validateArray([
                    "nome" => $data["nome"]  ?? "",
                    "cargo"=> $data["cargo"] ?? "",
                    "senha"=> $data["senha"] ?? "",
                ]);

                $fields["senha"] = password_hash($fields['senha'], PASSWORD_DEFAULT);

                $userModel = UserModel::updateUser($fields, $token->id);

                return $userModel;
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
        public static function deleteUser(mixed $auth): array
        {
            try {
                if (isset($auth["error"])){
                    return ["unauthorized" => $auth["error"]];
                }
                $token = JWToken::validateToken($auth);
                if (!$token) return ["unauthorized"=> "Voce nao esta autorizado a essa operacao faca login"];

                $userModel = UserModel::deleteUser($token->id, $token->id_empresa);
                return $userModel;
                
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            } catch (Exception $e) {
                return ["error"=> $e->getMessage()];
            }
        }
    }