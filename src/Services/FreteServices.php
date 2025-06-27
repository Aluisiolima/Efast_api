<?php
    namespace App\Services;

    use App\Http\JWToken;
    use App\Model\FreteModel;
    use App\Validations\FreteValidate\FreteEmpresa;
    use Exception;
    use PDOException;

    class FreteServices extends ServicesBase
    {
        public function __construct(
            private readonly FreteModel $freteModel,
            private readonly JWToken $jwToken
        ) {
            parent::__construct($jwToken);
        }

        public function calcFrete(array $data, int $id): array
        {
            try {
                $frete = new FreteEmpresa($data);
                $empresa = $this->freteModel->calcFrete($id);
                $distancia = $this->calcularDistancia($frete->lat,$frete->lon, $empresa["lat"],$empresa["lon"]);

                return ["frete" =>  (int) ($distancia * $empresa["t_frete"])];

            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        public function frete(array $data, mixed $auth): array
        {
            try {
                $token = $this->verificaToken($auth);
               
                return $this->freteModel->frete(new FreteEmpresa($data), $token->id);
        
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        private function calcularDistancia($lat1, $lon1, $lat2, $lon2): int {
            static $raioTerra = 6371; // km

            $lat1Rad = deg2rad($lat1);
            $lat2Rad = deg2rad($lat2);
            $dLat = deg2rad($lat2 - $lat1);
            $dLon = deg2rad($lon2 - $lon1);

            $a = sin($dLat / 2) ** 2 +
                cos($lat1Rad) * cos($lat2Rad) *
                sin($dLon / 2) ** 2;

            return $raioTerra * (2 * atan2(sqrt($a), sqrt(1 - $a)));
        }

    }