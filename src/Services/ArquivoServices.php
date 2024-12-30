<?php
    namespace App\Services;

    use App\Http\JWToken;
    use App\Model\ArquivoModel;
    use App\Utils\Validator;
    use Exception;
    use PDOException;

    /**
     * Classe ArquivoServices
     *
     * Responsável por gerenciar as operações de negócio relacionadas aos arquivos.
     */
    class ArquivoServices
    {
        /**
         * Obtém os arquivos associados à empresa autenticada.
         *
         * @param mixed $auth Dados de autenticação (token de acesso).
         * @return array Retorna os arquivos da empresa ou mensagens de erro/autorização.
         */
        public static function pegarArquivo(mixed $auth): array
        {
            try {
                if (isset($auth["error"])) {
                    return ["unauthorized" => $auth["error"]];
                }

                $token = JWToken::validateToken($auth);
                if (!$token) {
                    return ["unauthorized" => "Você não está autorizado a esta operação. Faça login."];
                }

                return ArquivoModel::pegarArquivo($token->id_empresa);
            } catch (Exception | PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        /**
         * Insere um arquivo associado à empresa autenticada.
         *
         * @param array $data Dados do arquivo a ser inserido.
         * @param mixed $auth Dados de autenticação (token de acesso).
         * @return array Retorna uma mensagem de sucesso ou erro.
         */
        public static function inserirArquivo(array $data, mixed $auth): array
        {
            try {
                if (isset($auth["error"])) {
                    return ["unauthorized" => $auth["error"]];
                }

                $token = JWToken::validateToken($auth);
                if (!$token) {
                    return ["unauthorized" => "Você não está autorizado a esta operação. Faça login."];
                }

                $fields = Validator::validateImg($data['img'], "$token->id_empresa/");
                $urlImg = str_replace('../', '', self::upload($fields, $data['img']));

                return ArquivoModel::inserirArquivo($urlImg, $token->id_empresa);
            } catch (Exception | PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        /**
         * Exclui um arquivo associado à empresa autenticada.
         *
         * @param array $data Dados identificadores do arquivo.
         * @param mixed $auth Dados de autenticação (token de acesso).
         * @return array Retorna uma mensagem de sucesso ou erro.
         */
        public static function deleteArquivo(array $data, mixed $auth): array
        {
            try {
                if (isset($auth["error"])) {
                    return ["unauthorized" => $auth["error"]];
                }

                $token = JWToken::validateToken($auth);
                if (!$token) {
                    return ["unauthorized" => "Você não está autorizado a esta operação. Faça login."];
                }

                $fields = Validator::validateArray([
                    "id" => $data["id"] ?? "",
                ]);

                $arquivo = ArquivoModel::deleteArquivo($fields, $token->id_empresa);
                return self::remove($arquivo["path"]);
            } catch (Exception | PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        /**
         * Faz o upload de um arquivo para o diretório de destino.
         *
         * @param string $targetFile Caminho do arquivo de destino.
         * @param array $img Dados do arquivo enviado.
         * @return string Retorna o caminho do arquivo enviado.
         * @throws Exception Caso ocorra erro no envio do arquivo.
         */
        private static function upload(string $targetFile, array $img): string
        {
            try {
                if (move_uploaded_file($img['tmp_name'], $targetFile)) {
                    return $targetFile;
                }

                throw new Exception("Houve um erro ao enviar o arquivo.");
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        /**
         * Remove um arquivo do sistema.
         *
         * @param string $img Caminho do arquivo a ser removido.
         * @return array Retorna uma mensagem de sucesso ou erro.
         */
        private static function remove(string $img): array
        {
            try {
                $caminhoImagem = "../$img";

                if (file_exists($caminhoImagem)) {
                    if (unlink($caminhoImagem)) {
                        return ["message" => "Arquivo deletado com sucesso!!"];
                    }

                    return ["error" => "Falha ao apagar a imagem."];
                }

                return ["error" => "Imagem não encontrada."];
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
        }
    }
