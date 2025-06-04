<?php
    namespace App\Services;

    use App\Http\JWToken;
    use App\Model\ArquivoModel;
    use App\Utils\Validator;
    use Intervention\Image\ImageManager;
    use Intervention\Image\Drivers\Gd\Driver;
    use Exception;
    use PDOException;

    /**
     * Classe ArquivoServices
     *
     * Responsável por gerenciar as operações de negócio relacionadas aos arquivos.
     */
    class ArquivoServices extends ServicesBase
    {
        public function __construct(
            private readonly ArquivoModel $arquivoModel,
            private readonly JWToken $jwToken,
        ) {
            parent::__construct($jwToken);
        }
        
        /**
         * Obtém os arquivos associados à empresa autenticada.
         *
         * @param mixed $auth Dados de autenticação (token de acesso).
         * @return array Retorna os arquivos da empresa ou mensagens de erro/autorização.
         */
        public function pegarArquivo(mixed $auth): array
        {
            try {   
                $token = $this->verificaToken($auth);

                return $this->arquivoModel->pegarArquivo($token->id_empresa);
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
        public function inserirArquivo(array $data, mixed $auth): array
        {
            try {
                
                $token = $this->verificaToken($auth);

                Validator::validateImg($data['img'], "$token->id_empresa/");

                $hash = hash_file('sha256', $data['img']['tmp_name']);
                $fileName = $hash . '.webp';

                $diretorio = "../uploads/$token->id_empresa/";
                if (!is_dir($diretorio)) {
                    mkdir($diretorio, 0755, true);
                }

                $destino = $diretorio . $fileName;

                if (file_exists($destino)) {
                    return ["error" => "Arquivo já existe."];
                }
                $urlImg = "uploads/$token->id_empresa/$fileName";

                $this->processaImagemToWebp($data['img']['tmp_name'], $destino);

                return $this->arquivoModel->inserirArquivo($urlImg, $token->id_empresa);
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
        public function deleteArquivo(int $id, mixed $auth): array
        {
            try {
                
                var_dump($id);
                $token = $this->verificaToken($auth);

                $arquivo = $this->arquivoModel->deleteArquivo($id, $token->id_empresa);

                if (isset($arquivo["error"])) {
                    return $arquivo; // Retorna o erro se houver
                }
                
                return $this->remove($arquivo["path"]);
            } catch (Exception | PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        /**
         * Processa uma imagem e a salva no formato WebP.
         *
         * @param string $originalPath Caminho da imagem original.
         * @param string $targetPath Caminho onde a imagem processada será salva.
         * @return void Apenas salva a imagem no formato WebP.
         */
        private function processaImagemToWebp(string $originalPath, string $targetPath): void
        {
            try {
                $manager = new ImageManager(driver: new Driver());
                $image = $manager->read($originalPath);

                if ($image->width() > 200) {
                    $image = $image->scale(width: 200); // Mantém a proporção
                }

                $image->toWebp(quality: 90)->save($targetPath);
            } catch (Exception $e) {
                throw new Exception("Erro ao processar a imagem: " . $e->getMessage());
            }
        }


        /**
         * Remove um arquivo do sistema.
         *
         * @param string $img Caminho do arquivo a ser removido.
         * @return array Retorna uma mensagem de sucesso ou erro.
         */
        private function remove(string $img): array
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
