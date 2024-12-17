<?php
    namespace App\Http;

    class Resquest
    {
        public static function method()
        {
            return $_SERVER["RESQUEST_METHOD"];
        }
    }