<?php
    namespace App\Services;

    use App\Validations\EmpresaValidate\FreteEmpresa;
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

        public static function calcFrete(array $data, int $id): array
        {
            try {
                $frete = new FreteEmpresa($data);
                $empresa = EmpresaModel::calcFrete($id);
                $distancia = self::calcularDistancia($frete->lat,$frete->lon, $empresa["lat"],$empresa["lon"]);

                return ["frete" =>  $distancia * (float) $empresa["t_frete"]];

            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        public static function frete(array $data, mixed $auth): array
        {
            try {
                if (isset($auth["error"])) {
                    return ["unauthorized" => $auth["error"]];
                }

                $token = JWToken::validateToken($auth);
                if (!$token) return ["unauthorized" => "Você não está autorizado a essa operação. Faça login."];
               
                return EmpresaModel::frete(new FreteEmpresa($data), $token->id);
        
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        private static function calcularDistancia($lat1, $lon1, $lat2, $lon2): int {
            $raioTerra = 6371; // Raio da Terra em km
        
            // Converte graus para radianos
            $lat1 = deg2rad($lat1);
            $lon1 = deg2rad($lon1);
            $lat2 = deg2rad($lat2);
            $lon2 = deg2rad($lon2);
        
            // Diferenças
            $dLat = $lat2 - $lat1;
            $dLon = $lon2 - $lon1;
        
            // Fórmula de Haversine
            $a = sin($dLat/2) * sin($dLat/2) +
                 cos($lat1) * cos($lat2) *
                 sin($dLon/2) * sin($dLon/2);
            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
            $distancia = $raioTerra * $c;
            return $distancia ;
        }
        
    }
