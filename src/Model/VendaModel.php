<?php 
    namespace App\Model;

    use PDO;
    use PDOException;

    /**
     * Class VendaModel
     * Classe responsável por realizar operações relacionadas às vendas.
     */
    class VendaModel extends Database
    {
        /**
         * Busca todas as vendas de uma empresa.
         * @param array $data Dados necessários para a consulta (exemplo: id_empresa).
         * @return array Lista de vendas ou mensagem de erro.
         */
        public static function pegarVendas(array $data): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "SELECT 
                            ped.id_pedido, 
                            ped.nome_cliente, 
                            ped.tipo_pagamento,
                            ped.numero_contato, 
                            ped.rua, 
                            ped.bairro, 
                            ped.numero_casa, 
                            ped.numero_mesa, 
                            ped.mesa, 
                            ped.data_pedido,
                            p.nome_produto, 
                            p.valor,
                            v.quantidade
                        FROM venda v
                        JOIN produtos p ON v.id_produto = p.id_produto
                        JOIN pedido ped ON v.id_pedido = ped.id_pedido
                        WHERE v.id_empresa = ?";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["id_empresa"]
                ]);

                $vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $vendas;
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }

        /**
         * Busca todas as vendas de uma empresa em uma data específica.
         * @param array $data Dados necessários para a consulta (exemplo: id_empresa).
         * @param string $day Data no formato 'd/m/Y'.
         * @return array Lista de vendas no dia especificado ou mensagem de erro.
         */
        public static function pegarVendasDay(array $data, string $day): array
        {
            try {
                $pdo = self::getConnection();
                $sql = "SELECT 
                            ped.id_pedido, 
                            ped.nome_cliente, 
                            ped.tipo_pagamento, 
                            ped.rua, 
                            ped.bairro, 
                            ped.numero_casa, 
                            ped.numero_mesa, 
                            ped.mesa, 
                            ped.data_pedido,
                            p.nome_produto, 
                            p.valor,
                            v.quantidade
                        FROM venda v
                        JOIN produtos p ON v.id_produto = p.id_produto
                        JOIN pedido ped ON v.id_pedido = ped.id_pedido
                        WHERE v.id_empresa = ?
                        AND STR_TO_DATE(ped.data_pedido, '%d/%m/%Y') = STR_TO_DATE(?, '%d/%m/%Y');";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $data["id_empresa"],
                    $day
                ]);

                $vendas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $vendas;
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }
        }
    }
