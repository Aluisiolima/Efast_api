<?php
    namespace App\Validations\EmpresaValidate;
    use InvalidArgumentException;

    class FreteEmpresa
    {
        public ?float $lat;
        public ?float $lon;
        public ?float $t_frete; 

        public function __construct(array $data)
        {
            if (empty($data["lat"]) && empty($data["lon"])) {
                throw new InvalidArgumentException("tanto a lat quanto a lon é obrigatório.");
            }

            $this->lat = $data["lat"];
            $this->lon = $data["lon"];
            $this->t_frete = $data["t_frete"] ?? null;
        }
    }