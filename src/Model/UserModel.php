<?php
    namespace App\Model;

    use PDOException;
    use PDO;
    class UserModel extends Database
    {
        public static function pegarUser(int $id): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "SELECT id_adm,nome,cargo,codigo FROM user_adm WHERE id_empresa = ?";
                $stmt = $pdo->prepare($sql);

                $stmt->execute([$id]);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }
        public static function inserirUser(array $data, int $id): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "INSERT INTO user_adm (nome,cargo,codigo,senha,id_empresa) VALUES (?,?,?,?,?);";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["nome"],
                    $data["cargo"],
                    $data["codigo"],
                    $data["senha"],
                    $id,
                ]);

                return [
                    "message" => "sucesso em inserir o user adm",
                    "dados" => [
                        "nome"   => $data["nome"],
                        "cargo"  => $data["cargo"],
                        "codigo" => $data["codigo"]
                    ]
                ];
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        public static function login(array $data): array
        {
            try {
                $pdo = self::getConnection();

                $stmt = $pdo->prepare("SELECT * FROM user_adm WHERE nome = ? AND cargo = ? AND codigo = ? AND id_empresa = ?;");

                $stmt->execute([
                    $data["nome"], 
                    $data["cargo"],
                    $data["codigo"],
                    $data["id_empresa"],
                ]);

                if ($stmt->rowCount() < 1) return ["error"=> "Nao existe user como esse parametros"];

                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if(!password_verify($data["senha"], $user["senha"])) return ["error"=> "Sua senha esta errada!!!"];

                return [
                    "nome"  => $user["nome"],
                    "cargo" => $user["cargo"],
                    "codigo"=> $user["codigo"],
                    "id"    => $user["id_empresa"],
                ];
            } catch (PDOException $e) {
                return ["error"=> $e->getMessage()];
            }
        }
    }