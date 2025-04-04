<?php
    namespace App\Validations\ProdutosValidate;

    use InvalidArgumentException;

    class UpdateProdutos
    {
        public int $id;
        public ?string $nome;
        public ?int $valor;
        public ?string $tipo;
        public ?int $id_img;
        public ?int $desconto;

        public function __construct(array $data)
        {
            if (empty($data["id"])) {
                throw new InvalidArgumentException("O id do Produto é obrigatório.");
            }

            $this->id = $data["id"];
            $this->nome = $data["nome"] ?? null;
            $this->valor = $data["valor"] ?? null;
            $this->tipo = $data["tipo"] ?? null;
            $this->id_img = $data["id_img"] ?? null;
            $this->desconto = $data["desconto"] ?? null;
        }
    }