<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    require_once __DIR__ ."/vendor/autoload.php";
    require_once __DIR__ ."/src/Routes/main.php";

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    use App\Core\Core;
    use App\Http\Routes;

    Core::dispatch(Routes::routes());