<?php
    use App\Http\Routes;

    Routes::get("/", "HomeController@index");

    //Produtos
    Routes::get("/pegarProdutos/{id}",  "ProdutosController@pegarProdutos");
    Routes::get("/pegarProdutos/{id}/main","ProdutosController@pegarProdutosMain");
    Routes::post("/inseriProdutos",     "ProdutosController@inseriProdutos");
    Routes::put("/updateProdutos",      "ProdutosController@updateProdutos");
    Routes::delete("/desativaProdutos", "ProdutosController@desativaProdutos");
    Routes::post("/ativaProdutos",      "ProdutosController@ativaProdutos");

    //Pedido
    Routes::post("/inserirPedido/{id}", "PedidoController@inserirPedido");

    //Venda
    Routes::post("/pegarVendas", "VendaController@pegarVendas");
    Routes::post("/pegarVendas/hoje", "VendaController@pegarVendasDay");
    
