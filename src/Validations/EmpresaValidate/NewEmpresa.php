<?php
    namespace App\Validations\EmpresaValidate;

    use InvalidArgumentException;

    class NewEmpresa 
    {
        public string $nome;
        public string $endereco;
        public string $whastapp;
        public int $logo;
        public ?string $instagram;
        public ?string $facebook;
        public ?string $email;

        public function __construct(array $data)
        {
            if (empty($data["nome"])) {
                throw new InvalidArgumentException("O nome é obrigatório.");
            }
            if (empty($data["endereco"])) {
                throw new InvalidArgumentException("O endereco é obrigatório.");
            }
            if (empty($data["whatsapp"])) {
                throw new InvalidArgumentException("O whatsapp é obrigatório.");
            }
            if (empty($data["logo"])) {
                throw new InvalidArgumentException("A logo é obrigatório.");
            }

            $this->nome = $data["nome"];
            $this->endereco = $data["endereco"];
            $this->whastapp = $data["whatsapp"];
            $this->logo = $data["logo"];
            $this->instagram = $data["instagram"] ?? null;
            $this->facebook = $data["facebook"] ?? null;
            $this->email = $data["email"] ?? null;
        }
    }
