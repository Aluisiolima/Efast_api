<?php
    namespace App\Model;

    use PDOException;
    use PDO;
    class UserModel extends Database
    {
        public static function inserirUser(array $data): array
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
                    $data["id_empresa"]
                ]);

                return [
                    "message"=> "sucesso em inserir o user adm",
                    "dados"=> [
                        $data["nome"],
                        $data["cargo"],
                        $data["codigo"]
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