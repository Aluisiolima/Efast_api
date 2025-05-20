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