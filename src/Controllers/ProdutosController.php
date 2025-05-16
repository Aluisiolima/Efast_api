<?php
    namespace App\Controllers;

    use App\Http\Response;
    use App\Http\Resquest;
    use App\Services\ProdutosServices;
    use App\Controllers\ControllerBase;

    class ProdutosController extends ControllerBase
    {
        public function __construct(
            private readonly Resquest $resquest,
            private readonly Response $response,
            private readonly ProdutosServices $produtosServices,
        ){
            parent::__construct($response);
        }

        public function pegarProdutos(string $id): void 
        {
            $produtos = $this->produtosServices->pegarProdutos((int) $id);
    
            $this->responserController($produtos, 200);
        }

        public function pegarProdutosUnico(string $id): void 
        {
            $produtos = $this->produtosServices->pegarProdutosUnico((int) $id);

            $this->responserController($produtos, 200);
        }

        public function getTypes(): void 
        {
            $auth = $this->resquest::authorization();
            $produtos = $this->produtosServices->getTypes($auth);
    
            $this->responserController($produtos, 200);
        }

        public function inseriProdutos(): void 
        {
            $body = $this->resquest::getBody();
            $auth = $this->resquest::authorization();
            $produtos = $this->produtosServices->inseriProdutos($body, $auth);
    
            $this->responserController($produtos, 201);
        }

        public function updateProdutos(): void 
        {
            $body = $this->resquest::getBody();
            $auth = $this->resquest::authorization();
            $produtos = $this->produtosServices->updateProdutos($body, $auth);

            $this->responserController($produtos, 200);
        }

        public function desativaProdutos(string $id): void
        {
            $auth = $this->resquest::authorization();
            $produtos = $this->produtosServices->desativaProdutos((int) $id, $auth);

            $this->responserController($produtos, 200);
        }
        
        public function ativaProdutos(string $id): void
        {
            $auth = $this->resquest::authorization();
            $produtos = $this->produtosServices->ativaProdutos((int) $id, $auth);

            $this->responserController($produtos, 200);
        }
        
        public function pegarProdutosMain(string $id): void
        {
            $produtos = $this->produtosServices->pegarProdutosMain((int) $id);
    
            $this->responserController($produtos, 200);
        }
    }