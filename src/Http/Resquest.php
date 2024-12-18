<?php
    namespace App\Http;

    class Resquest
    {
        public static function method(): string
        {
            return $_SERVER["REQUEST_METHOD"];
        }
    }