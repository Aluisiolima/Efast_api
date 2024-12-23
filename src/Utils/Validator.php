<?php
    namespace App\Utils;

    use Exception;

    class Validator
    {
        public static function validateArray(array $datas): array
        {
            foreach($datas as $date => $value)
            {
                if(empty(trim((string) $value))){
                    throw new Exception("O campo {$value} é obrigatorio!!");
                }

                $datas[$date] = is_string($value) ? strtolower($value) : $value;
            }
            
            return $datas;
        }
    }