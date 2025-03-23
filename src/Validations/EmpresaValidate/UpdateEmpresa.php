<?php
    namespace App\Validations\EmpresaValidate;

    class UpdateEmpresa
    {
        public ?string $nome;
        public ?string $endereco;
        public ?string $whastapp;
        public ?int $logo;
        public ?string $instagram;
        public ?string $facebook;
        public ?string $email;

        public function __construct(array $data)
        {
            $this->nome = $data["nome"];
            $this->endereco = $data["endereco"];
            $this->whastapp = $data["whastapp"];
            $this->logo = $data["logo"];
            $this->instagram = $data["instagram"];
            $this->facebook = $data["facebook"];
            $this->email = $data["email"];
        }
    }