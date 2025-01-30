<?php
    require_once __DIR__ ."/vendor/autoload.php";
    require_once __DIR__ ."/src/Routes/main.php";
    require_once __DIR__ ."/config.php";
    
    if (class_exists("Dotenv\Dotenv")) {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
        $dotenv->load();
    }
    use App\Core\Core;
    use App\Http\Routes;

    Core::dispatch(Routes::routes());