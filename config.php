<?php
    declare(strict_types=1);
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: https://efastmenu.com");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit(); 
    }

