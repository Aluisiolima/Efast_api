<?php
    use App\Http\Routes;

    Routes::get("/", "HomeController@index");

    //Produtos
    Routes::get("/pegarProdutos/{id}",  "ProdutosController@pegarProdutos");
    Routes::post("/inseriProdutos",     "ProdutosController@inseriProdutos");
    Routes::put("/updateProdutos",      "ProdutosController@updateProdutos");
    Routes::delete("/desativaProdutos", "ProdutosController@desativaProdutos");
    Routes::post("/ativaProdutos",      "ProdutosController@ativaProdutos");

    //Pedido
    Routes::post("/inserirPedido", "PedidoController@inserirPedido");
    
    
