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
        public function pegarVendas(int $id_empresa): array
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
                            ped.status,
                            p.nome_produto, 
                            p.valor,
                            v.desconto_aplicado,
                            v.quantidade
                        FROM venda v
                        JOIN produtos p ON v.id_produto = p.id_produto
                        JOIN pedido ped ON v.id_pedido = ped.id_pedido
                        WHERE v.id_empresa = ?;";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $id_empresa
                ]);

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } finally {
                $pdo = null;
            }
        }

        /**
         * Busca todas as vendas de uma empresa em uma data específica.
         * @param array $data Dados necessários para a consulta (exemplo: id_empresa).
         * @param string $day Data no formato 'd/m/Y'.
         * @return array Lista de vendas no dia especificado ou mensagem de erro.
         */
        public function pegarVendasDay(int $id_empresa, string $day): array
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
                            ped.status,
                            p.nome_produto, 
                            p.valor,
                            v.desconto_aplicado,
                            v.quantidade
                        FROM venda v
                        JOIN produtos p ON v.id_produto = p.id_produto
                        JOIN pedido ped ON v.id_pedido = ped.id_pedido
                        WHERE v.id_empresa = ?
                        AND STR_TO_DATE(ped.data_pedido, '%d/%m/%Y') = STR_TO_DATE(?, '%d/%m/%Y');";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    $id_empresa,
                    $day
                ]);

                return  $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            } finally {
                $pdo = null;
            }
        }
    }
