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
                $response::json($produtos["error"],400,true);
                return;
            }
            $response::json($produtos,200);
    
        }
        public function inseriProdutos(Resquest $resquest, Response $response) 
        {
            $body = $resquest::getBody();
            $produtos = ProdutosServices::inseriProdutos($body);
    
            if(isset($produtos["error"])){
                $response::json($produtos["error"],400,true);
                return;
            }
            $response::json($produtos,200);
    
        }
        public function updateProdutos(Resquest $resquest, Response $response) 
        {
            $body = $resquest::getBody();
            $produtos = ProdutosServices::updateProdutos($body);
    
            if(isset($produtos["error"])){
                $response::json($produtos["error"],400,true);
                return;
            }
            $response::json($produtos,200);
    
        }
    }