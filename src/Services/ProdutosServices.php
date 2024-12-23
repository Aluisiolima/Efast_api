<?php
    namespace App\Services;

    use App\Model\ProdutosModel;
    use App\Utils\Validator;
    use Exception;
    use PDOException;

    class ProdutosServices
    {
        public static function pegarProdutos(array $data): array
        {
            try {
                $fields = Validator::validateArray([
                    "id_empresa" => $data[0] ?? ""
                ]);

                $produtosModel = ProdutosModel::pegarProdutos($fields);
                
                return $produtosModel;
                
            } catch (PDOException $e) {
                return ["error" => $e];
            } catch (Exception $e) {
                return ["error" => $e];
            }
            
        }

        public static function inseriProdutos(array $data): array
        {
            try {
                $fields = Validator::validateArray([
                    "nome"      => $data["nome"]        ?? "",
                    "valor"     => $data["valor"]       ?? "",
                    "tipo"      => $data["tipo"]        ?? "",
                    "id_img"    => $data["id_img"]      ?? "",
                    "id_empresa"=> $data["id_empresa"]  ?? ""
                ]);
                $produtosModel = ProdutosModel::inseriProdutos($fields);

                return $produtosModel;

            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }catch (Exception $e) {
                return ["error"=> $e->getMessage()];
            }
        }
        public static function updateProdutos(array $data): array
        {
            try {
                $fields = Validator::validateArray([
                    "id"    => $data["id"]      ?? "",
                    "nome"  => $data["nome"]    ?? "",
                    "valor" => $data["valor"]   ?? "",
                    "tipo"  => $data["tipo"]    ?? "",
                    "id_img"=> $data["id_img"]  ?? ""
                ]);
                $produtosModel = ProdutosModel::updateProdutos($fields);

                return $produtosModel;

            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            } catch (Exception $e) {
                return ["error"=> $e->getMessage()];
            }
        }
        public static function desativaProdutos(array $data): array
        {
            try {
                $fields = Validator::validateArray([
                    "id" => $data["id"] ?? "",
                ]);
                $produtosModel = ProdutosModel::desativaProdutos($fields);

                return $produtosModel;
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            } catch (Exception $e) {
                return ["error"=> $e->getMessage()];
            }
        }

        public static function ativaProdutos(array $data): array
        {
            try {
                $fields = Validator::validateArray([
                    "id" => $data["id"] ?? "",
                ]);
                $produtosModel = ProdutosModel::ativaprodutos($fields);
                
                return $produtosModel;
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            } catch (Exception $e) {
                return ["error"=> $e->getMessage()];
            }
        }
    }
