<?php
    declare(strict_types=1);
    date_default_timezone_set('America/Sao_Paulo');
    
    $allowed_origins = [
        "https://efastmenu.com",
        "https://www.efastmenu.com",
        "https://admin.efastmenu.com",
        "http://localhost:3000",
    ];

    $origin = $_SERVER['HTTP_ORIGIN'] ?? '';
       
    if (in_array($origin, $allowed_origins)) {
        header("Access-Control-Allow-Origin: $origin");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Allow-Credentials: true");
        
        
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit(); 
        }
    }
    
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);