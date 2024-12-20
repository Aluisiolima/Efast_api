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
    }
