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
    
    //Empresa
    Routes::get("/pegarEmpresas" , "EmpresaController@pegarEmpresa");
    Routes::get("/pegarEmpresa/{id}" , "EmpresaController@pegarEmpresaOne");
    Routes::post("/inserirEmpresa" , "EmpresaController@inserirEmpresa");
    Routes::put("/updateEmpresa" , "EmpresaController@updateEmpresa");
    Routes::delete("/desativaEmpresa" , "EmpresaController@desativaEmpresa");
    Routes::post("/ativaEmpresa" , "EmpresaController@ativaEmpresa");

    //Arquivo
    Routes::post("/pegarArquivo" , "ArquivoController@pegarArquivo");
    Routes::post("/inserirArquivo/icon" , "ArquivoController@inserirArquivo");
    Routes::delete("/deleteArquivo" , "ArquivoController@deleteArquivo");

    //user_adm
    Routes::post("/pegarUser", "UserController@pegarUser");
    Routes::post("/login", "UserController@login");
    Routes::post("/inserirUser", "UserController@inserirUser");
    Routes::put("/updateUser", "UserController@updateUser");
    Routes::delete("/deleteUser", "UserController@deleteUser");