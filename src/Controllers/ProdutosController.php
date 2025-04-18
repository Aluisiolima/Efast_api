<?php
    namespace App\Controllers;

    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\ProdutosServices;

    class ProdutosController 
    {
        private readonly Resquest $resquest;
        private readonly Response $response;

        public function __construct(){
            $this->resquest = new Resquest;
            $this->response = new Response;
        }

        public function pegarProdutos(array $id) 
        {
    
            $produtos = ProdutosServices::pegarProdutos($id);
    
            if(isset($produtos["error"])){
                $this->response::json($produtos,400,true);
                return;
            }
            $this->response::json($produtos,200);
    
        }

        public function pegarProdutosUnico(array $id) 
        {
    
            $produtos = ProdutosServices::pegarProdutosUnico($id);
    
            if(isset($produtos["error"])){
                $this->response::json($produtos,400,true);
                return;
            }
            $this->response::json($produtos,200);
    
        }

        public function getTypes(array $id) 
        {
            $auth = $this->resquest::authorization();
            $produtos = ProdutosServices::getTypes($id, $auth);
    
            if (isset($produtos["unauthorized"])){
                $this->response::json($produtos,401,true);
                return;
            }

            if(isset($produtos["error"])){
                $this->response::json($produtos,400,true);
                return;
            }
            
            $this->response::json($produtos,200);
    
        }

        public function inseriProdutos() 
        {
            $body = $this->resquest::getBody();
            $auth = $this->resquest::authorization();
            $produtos = ProdutosServices::inseriProdutos($body, $auth);

            if (isset($produtos["unauthorized"])){
                $this->response::json($produtos,401,true);
                return;
            }
    
            if(isset($produtos["error"])){
                $this->response::json($produtos,400,true);
                return;
            }
            $this->response::json($produtos,200);
    
        }

        public function updateProdutos() 
        {
            $body = $this->resquest::getBody();
            $auth = $this->resquest::authorization();
            $produtos = ProdutosServices::updateProdutos($body, $auth);
    
            if (isset($produtos["unauthorized"])){
                $this->response::json($produtos,401,true);
                return;
            }

            if(isset($produtos["error"])){
                $this->response::json($produtos,400,true);
                return;
            }
            $this->response::json($produtos,200);
    
        }

        public function desativaProdutos(): void
        {
            $body = $this->resquest::getBody();
            $auth = $this->resquest::authorization();
            $produtos = ProdutosServices::desativaProdutos($body, $auth);

            if (isset($produtos["unauthorized"])){
                $this->response::json($produtos,401,true);
                return;
            }

            if(isset($produtos["error"])){
                $this->response::json($produtos,400,true);
                return;
            }
            $this->response::json($produtos,200);
        }
        
        public function ativaProdutos(): void
        {
            $body = $this->resquest::getBody();
            $auth = $this->resquest::authorization();
            $produtos = ProdutosServices::ativaProdutos($body, $auth);
            
            if (isset($produtos["unauthorized"])){
                $this->response::json($produtos,401,true);
                return;
            }

            if(isset($produtos["error"])){
                $this->response::json($produtos,400,true);
                return;
            }
            $this->response::json($produtos,200);
        }
        
        public function pegarProdutosMain(array $id): void
        {
            $produtos = ProdutosServices::pegarProdutosMain($id);
    
            if(isset($produtos["error"])){
                $this->response::json($produtos,400,true);
                return;
            }
            $this->response::json($produtos,200);
    
        }
    }