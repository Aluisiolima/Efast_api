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

        public static function inserirArquivo(array $data, mixed $auth): array
        {
            try {
                if(isset($auth["error"])){
                    return ["unauthorized" => $auth["error"]];
                }
                $token = JWToken::validateToken($auth);

                if (!$token) return ["unauthorized" => "Voce nao esta autorizado a essa operacao faca login"];

                $fields = Validator::validateImg($data['img'],"$token->id_empresa/");

                $urlImg = str_replace('../', '', self::upload($fields,$data['img']));

                $arquivo = ArquivoModel::inserirArquivo($urlImg, $token->id_empresa);

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

                $arquivoDeletado = self::remove($arquivo["path"]);

                return $arquivoDeletado;
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        private static function upload(string $targetFile, array $img)
        {
            try {
                // Move o arquivo para o diretório de destino
                if (move_uploaded_file($img['tmp_name'], $targetFile)) {
                    return $targetFile;
                } else {
                    throw new Exception("Houve um erro ao enviar o arquivo.");
                }
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }
        private static function remove(string $img): array
        {
            try{
                $caminhoImagem = "../$img";
    
                // Verifica se o arquivo existe
                if (file_exists($caminhoImagem)) {
                    // Tenta apagar o arquivo
                    if (unlink($caminhoImagem)) {
                        return [
                            "message"=> "Arquivo deletado com sucesso!!",
                        ];
                    } else {
                        return ["error" => "Falha ao apagar a imagem."];
                    }
                } else {
                    return ["error" => "Imagem não encontrada."];
                }
            }catch (Exception $e) {
                return ["error"=> $e->getMessage()];
            }
        }
    }