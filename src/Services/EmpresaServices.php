<?php
    namespace App\Services;

    use PDOException;
    use Exception;
    use App\Http\JWToken;
    use App\Model\EmpresaModel;
    use App\Utils\Validator;

    class EmpresaServices
    {
        public static function pegarEmpresa(): array
        {
            try {  
                $empresa = EmpresaModel::pegarEmpresa();

                return $empresa;
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
        }
        public static function inserirEmpresa(array $data, mixed $auth): array
        {
            try {  
                if (isset($auth["error"])){
                    return ["unauthorized" => $auth["error"]];
                }
                $token = JWToken::validateToken($auth);
                if (!$token) return ["unauthorized" => "Voce nao esta autorizado a essa operacao faca login"];

                $fields = Validator::validateArray([
                    "nome"      => $data["nome"]        ?? "",
                    "endereco"  => $data["endereco"]    ?? "",
                    "whastapp"  => $data["whastapp"]    ?? "",
                    "instagram" => $data["instagram"]   ?? "instagram",
                    "facebook"  => $data["facebook"]    ?? "facebook",
                    "email"     => $data["email"]       ?? "email",
                    "logo"      => $data["logo"]        ?? "",
                ]);

                $empresa = EmpresaModel::inserirEmpresa($fields);

                return $empresa;
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
        }
        public static function updateEmpresa(array $data, mixed $auth): array
        {
            try {  
                if (isset($auth["error"])){
                    return ["unauthorized"=> $auth["error"]];
                }
                $token = JWToken::validateToken($auth);
                if (!$token) return ["unauthorized" => "Voce nao esta autorizado a essa operacao faca login"];

                $fields = Validator::validateArray([
                    "nome"      => $data["nome"]        ?? "",
                    "endereco"  => $data["endereco"]    ?? "",
                    "whastapp"  => $data["whastapp"]    ?? "",
                    "instagram" => $data["instagram"]   ?? "",
                    "facebook"  => $data["facebook"]    ?? "",
                    "email"     => $data["email"]       ?? "",
                    "logo"      => $data["logo"]        ?? "",
                ]);
                if ($token->cargo !== "empresario") return ["error"=> "Voce nao tem autorizacao de atualiza essa empresa !!!"];

                $empresa = EmpresaModel::updateEmpresa($fields, $token->id_empresa);

                return $empresa;
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
        }

        public static function desativaEmpresa(array $data, mixed $auth): array
        {
            try {  
                if (isset($auth["error"])){
                    return ["unauthorized" => $auth["error"]];
                }
                $token = JWToken::validateToken($auth);
                if (!$token) return ["unauthorized" => "Voce nao esta autorizado a essa operacao faca login"];

                $fields = Validator::validateArray([
                    "id" => $data["id"] ?? "",
                ]);

                if ($token->cargo !== "dev") return ["error" => "Voce nao tem autorizacao de desativa essa empresa !!!"];

                $empresa = EmpresaModel::desativaEmpresa($fields);

                return $empresa;
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
        }

        public static function ativaEmpresa(array $data, mixed $auth): array
        {
            try {  
                if (isset($auth["error"])){
                    return ["unauthorized" => $auth["error"]];
                }
                $token = JWToken::validateToken($auth);
                if (!$token) return ["unauthorized" => "Voce nao esta autorizado a essa operacao faca login"];

                $fields = Validator::validateArray([
                    "id" => $data["id"] ?? "",
                ]);

                if ($token->cargo !== "dev") return ["error" => "Voce nao tem autorizacao de ativa essa empresa !!!"];

                $empresa = EmpresaModel::ativaEmpresa($fields);

                return $empresa;
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
        }
    }