<?php
    namespace App\Controllers;

    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\ProdutosServices;

    class ProdutosController 
    {
        public function pegarProdutos(Resquest $resquest, Response $response, array $id) 
        {
    
            $produtos = ProdutosServices::pegarProdutos($id);
    
            if(isset($produtos["error"])){
                $response::json($produtos,400,true);
                return;
            }
            $response::json($produtos,200);
    
        }

        public function pegarProdutosUnico(Resquest $resquest, Response $response, array $id) 
        {
    
            $produtos = ProdutosServices::pegarProdutosUnico($id);
    
            if(isset($produtos["error"])){
                $response::json($produtos,400,true);
                return;
            }
            $response::json($produtos,200);
    
        }

        public function getTypes(Resquest $resquest, Response $response, array $id) 
        {
            $auth = $resquest::authorization();
            $produtos = ProdutosServices::getTypes($id, $auth);
    
            if (isset($produtos["unauthorized"])){
                $response::json($produtos,401,true);
                return;
            }

            if(isset($produtos["error"])){
                $response::json($produtos,400,true);
                return;
            }
            
            $response::json($produtos,200);
    
        }

        public function inseriProdutos(Resquest $resquest, Response $response) 
        {
            $body = $resquest::getBody();
            $auth = $resquest::authorization();
            $produtos = ProdutosServices::inseriProdutos($body, $auth);

            if (isset($produtos["unauthorized"])){
                $response::json($produtos,401,true);
                return;
            }
    
            if(isset($produtos["error"])){
                $response::json($produtos,400,true);
                return;
            }
            $response::json($produtos,200);
    
        }

        public function updateProdutos(Resquest $resquest, Response $response) 
        {
            $body = $resquest::getBody();
            $auth = $resquest::authorization();
            $produtos = ProdutosServices::updateProdutos($body, $auth);
    
            if (isset($produtos["unauthorized"])){
                $response::json($produtos,401,true);
                return;
            }

            if(isset($produtos["error"])){
                $response::json($produtos,400,true);
                return;
            }
            $response::json($produtos,200);
    
        }

        public function desativaProdutos(Resquest $resquest, Response $response): void
        {
            $body = $resquest::getBody();
            $auth = $resquest::authorization();
            $produtos = ProdutosServices::desativaProdutos($body, $auth);

            if (isset($produtos["unauthorized"])){
                $response::json($produtos,401,true);
                return;
            }

            if(isset($produtos["error"])){
                $response::json($produtos,400,true);
                return;
            }
            $response::json($produtos,200);
        }
        
        public function ativaProdutos(Resquest $resquest, Response $response): void
        {
            $body = $resquest::getBody();
            $auth = $resquest::authorization();
            $produtos = ProdutosServices::ativaProdutos($body, $auth);
            
            if (isset($produtos["unauthorized"])){
                $response::json($produtos,401,true);
                return;
            }

            if(isset($produtos["error"])){
                $response::json($produtos,400,true);
                return;
            }
            $response::json($produtos,200);
        }
        
        public function pegarProdutosMain(Resquest $resquest, Response $response, array $id): void
        {
            $produtos = ProdutosServices::pegarProdutosMain($id);
    
            if(isset($produtos["error"])){
                $response::json($produtos,400,true);
                return;
            }
            $response::json($produtos,200);
    
        }
    }