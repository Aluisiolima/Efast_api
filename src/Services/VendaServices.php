<?php
    namespace App\Services;

    use App\Model\VendaModel;
    use App\Utils\Validator;
    use Exception;
    use PDOException;

    class VendaServices
    {
        public static function pegarVendas(array $data): array
        {
            try{
                $fields = Validator::validateArray([
                    "id_empresa" => $data[0] ?? ""
                ]);

                $vendas = VendaModel::pegarVendas($fields);

                return $vendas;
            } catch(Exception $e) {
                return ["error" => $e->getMessage()];
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }

        }
    }