<?php
    namespace App\Model;

    use App\Model\Database;
    use App\Validations\FreteValidate\FreteEmpresa;
    use PDO;
    use PDOException;

    class FreteModel extends Database
    {
        public function calcFrete(string $id): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "SELECT lat,lon,t_frete FROM empresa WHERE id_empresa = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$id]);

                return $stmt->fetch(PDO::FETCH_ASSOC);
            
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }finally {
                $pdo = null;
            }
        }

        public function frete(FreteEmpresa $frete, int $id): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "UPDATE empresa SET 
                            lon = COALESCE(?, lon),
                            lat = COALESCE(?, lat),
                            t_frete = COALESCE(?, t_frete)
                        WHERE id_empresa = ?;";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $frete->lon,
                    $frete->lat,
                    $frete->t_frete,
                    $id
                ]);

                return ["messagem" => "localização da empresa registrado com sucesso."];
            
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }finally {
                $pdo = null;
            }
        }

    }