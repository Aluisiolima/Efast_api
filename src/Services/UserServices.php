<?php
    namespace App\Services;

    use App\Model\UserModel;
    use App\Utils\Validator;
    use App\Http\JWToken;
    use Exception;
    use PDOException;

    class UserServices
    {
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

                $userModel = UserModel::inserirUser($fields, $token->id_empresa);

                return $userModel;
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
            catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
        }

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

                $token = JWToken::generateToken($userModel);
                return ["token" => $token];
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
            catch (Exception $e) {
                return ["error"=> $e->getMessage()];
            }
        }

        public static function updateUser(array $data, mixed $auth): array
        {
            try {
                if (isset($auth["error"])){
                    return ["unauthorized"=> $auth["error"]];
                }
                $token = JWToken::validateToken($auth);
                if (!$token) return ["unauthorized"=> "Voce nao esta autorizado a essa operacao faca login"];

                $fields = Validator::validateArray([
                    "nome" => $data["nome"] ?? "",
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