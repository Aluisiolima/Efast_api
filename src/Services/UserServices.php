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
                return [];
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
            catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
        }
        public static function inserirUser(array $data):array
        {
            try {
                $fields = Validator::validateArray([
                    "nome"      => $data["nome"]        ?? "",
                    "cargo"     => $data["cargo"]       ?? "",
                    "codigo"    => $data["codigo"]      ?? "",
                    "senha"     => $data["senha"]       ?? "",
                    "id_empresa"=> $data["id_empresa"]  ?? "",
                ]);

                $fields["senha"] = password_hash($fields['senha'], PASSWORD_DEFAULT);

                $userModel = UserModel::inserirUser($fields);

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
                if($userModel["id"] === 1) 
                {
                    $token = JWToken::generateTokenDev($userModel);
                    return ["token" => $token];
                }

                $token = JWToken::generateTokenUser($userModel);
                return ["token" => $token];
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
            catch (Exception $e) {
                return ["error"=> $e->getMessage()];
            }
        }
    }