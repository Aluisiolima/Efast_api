<?php
    namespace App\Http;

    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    use Exception;

    /**
     * Classe JWToken
     * 
     * Responsável por gerenciar e validar os tokens de acesso da aplicação.
     * Utiliza a biblioteca Firebase JWT para codificação e decodificação dos tokens.
     */
    class JWToken
    {
        /**
         * @var string $secret
         * Armazena a chave secreta utilizada para gerar e validar tokens.
         */
        private static $secret;

        /**
         * Gera um token JWT com os dados fornecidos.
         *
         * @param array $data Dados que serão incorporados no token.
         * @return string|array Retorna o token JWT gerado em formato string. 
         * Em caso de erro, retorna um array contendo a mensagem de erro.
         */
        public function generateToken(array $data = []): string|array
        {
            try {
                // Obtém a chave secreta do ambiente
                self::$secret = $_ENV["SECRET_KEY"];
                
                // Codifica os dados no token JWT
                return JWT::encode($data, self::$secret, "HS256");
            } catch (Exception $e) {
                return ["error" => $e->getMessage()];
            }
        }

        /**
         * Valida um token JWT fornecido.
         *
         * @param string $token Token JWT que será validado.
         * @return object|null Retorna os dados decodificados do token como um objeto em caso de sucesso.
         * Retorna null se o token for inválido ou ocorrer algum erro.
         */
        public function validateToken(string $token): ?object
        {
            try {
                // Obtém a chave secreta do ambiente
                self::$secret = $_ENV["SECRET_KEY"];
                
                // Decodifica e valida o token
                return JWT::decode($token, new Key(self::$secret, "HS256"));
            } catch (Exception $e) {
                // Retorna null em caso de erro
                return null;
            }
        }
    }
