<?php
    use App\Http\Routes;

    Routes::get("/", "HomeController@index");

    //Produtos
    Routes::post("/produto/inseri",     "ProdutosController@inseriProdutos");
    Routes::put("/produto/update",      "ProdutosController@updateProdutos");
    Routes::get("/produto/empresa/{id}",  "ProdutosController@pegarProdutos");
    Routes::get("/produto/{id}",  "ProdutosController@pegarProdutosUnico");
    Routes::get("/produto/empresa/{id}/main","ProdutosController@pegarProdutosMain");
    Routes::delete("/produto/desativa/{id}", "ProdutosController@desativaProdutos");
    Routes::post("/produto/ativa/{id}",      "ProdutosController@ativaProdutos");    
    Routes::post("/produto/getTypes/{id}",      "ProdutosController@getTypes");

    //Pedido
    Routes::post("/pedido/inserir/{id}", "PedidoController@inserirPedido");
    Routes::post("/pedido/status/{id}", "PedidoController@status");

    //Venda
    Routes::post("/venda", "VendaController@pegarVendas");
    Routes::post("/venda/hoje", "VendaController@pegarVendasDay");
    
    //Empresa
    Routes::get( "/empresa" , "EmpresaController@pegarEmpresa");
    Routes::post("/empresa/inserir" , "EmpresaController@inserirEmpresa");
    Routes::put("/empresa/update" , "EmpresaController@updateEmpresa");
    Routes::get("/empresa/{id}" , "EmpresaController@pegarEmpresaOne");
    Routes::delete("/empresa/desativa/{id}" , "EmpresaController@desativaEmpresa");
    Routes::post("/empresa/ativa/{id}" , "EmpresaController@ativaEmpresa");

    //Frete
    Routes::post("/frete/calc/{id}" , "FreteController@calcFrete");
    Routes::put("/frete/update" , "FreteController@frete");

    //QrCode
    Routes::post("/qrcode", "QrCodeController@qrcode");

    //Arquivo
    Routes::post("/arquivo" , "ArquivoController@pegarArquivo");
    Routes::post("/arquivo/inserir" , "ArquivoController@inserirArquivo");
    Routes::delete("/arquivo/delete" , "ArquivoController@deleteArquivo");

    //user_adm
    Routes::post("/user", "UserController@pegarUser");
    Routes::post("/user/inserir", "UserController@inserirUser");
    Routes::put("/user/update", "UserController@updateUser");
    Routes::delete("/user/delete", "UserController@deleteUser");

    //Login
    Routes::post("/login", "LoginController@login");
    Routes::post("/login/refresh", "LoginController@refreshLoginToken");
