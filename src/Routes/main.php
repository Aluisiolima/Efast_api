<?php
    use App\Http\Routes;

    Routes::get("/", "HomeController@index");

    Routes::get("/pegarProdutos/{id}", "ProdutosController@pegarProdutos");

