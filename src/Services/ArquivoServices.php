<?php 
    namespace App\Services;

use App\Http\JWToken;
use App\Model\ArquivoModel;
use App\Utils\Validator;
use Exception;
use PDOException;

    class ArquivoServices
    {
        public static function pegarArquivo(mixed $auth): array
        {
            try {
                if(isset($auth["error"])){
                    return ["unauthorized" => $auth["error"]];
                }
                $token = JWToken::validateToken($auth);

                if (!$token) return ["unauthorized" => "Voce nao esta autorizado a essa operacao faca login"];

                $arquivo = ArquivoModel::pegarArquivo($token->id_empresa);

                return $arquivo;
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        public static function deleteArquivo(array $data, mixed $auth): array
        {
            try {
                if(isset($auth["error"])){
                    return ["unauthorized" => $auth["error"]];
                }
                $token = JWToken::validateToken($auth);

                if (!$token) return ["unauthorized" => "Voce nao esta autorizado a essa operacao faca login"];

                $fiedls = Validator::validateArray([
                    "id" => $data["id"] ?? "",
                ]);

                $arquivo = ArquivoModel::deleteArquivo($fiedls, $token->id_empresa);

                return $arquivo;
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }
    }