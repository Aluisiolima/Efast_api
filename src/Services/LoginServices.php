<?php
    namespace App\Services;

    use App\Http\JWToken;
    use App\Model\UserModel;
    use App\Services\ServicesBase;
    use App\Utils\Validator;
use DASPRiD\Enum\Exception\MismatchException;
use Exception;
    use PDOException;

    class LoginServices extends ServicesBase
    {
        public function __construct(
            private readonly UserModel $userModel,
            private readonly JWToken $jwtoken
        ){
            parent::__construct($jwtoken);
        }

        /**
         * Responsavel por Fazer Login dos User ao entra no app
         * @param array $data
         * @return array
         */
        public function login(array $data): array
        {
            try {
                $fields = Validator::validateArray([
                    "nome"       => $data["nome"]       ?? "", 
                    "cargo"      => $data["cargo"]      ?? "",
                    "codigo"     => $data["codigo"]     ?? "",
                    "id_empresa" => $data["id_empresa"] ?? "",
                    "senha"      => $data["senha"]      ?? "",
                ]);

                $user = $this->userModel->login($fields);

                $token = $this->jwtoken->generateToken($user);
                return ["token" => $token];
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
            catch (Exception $e) {
                return ["error"=> $e->getMessage()];
            }
        }


        /**
         * Responsavel por Fazer um refresh no Login dos User para ficar fanzendo login continuamente abusando de banco sem necessidade
         * @param array $data
         * @return array
         */
        public function refreshLoginToken(mixed $auth): array
        {
            try {
                $validToken = $this->verificaToken($auth);

                $fields = Validator::validateArray([
                    "id_empresa" => $validToken->id_empresa ?? "",
                    "nome"       => $validToken->nome       ?? "",
                    "cargo"      => $validToken->cargo      ?? "",
                    "codigo"     => $validToken->codigo     ?? "",
                    "id"         => $validToken->id         ?? "",
                ]);
                
                $token = $this->jwtoken->generateToken($fields);
                return ["token" => $token];
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
            catch (Exception $e) {
                return ["error"=> $e->getMessage()];
            }
        }

    }