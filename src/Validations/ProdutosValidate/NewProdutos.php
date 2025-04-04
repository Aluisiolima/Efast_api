<?php
    namespace App\Validations\ProdutosValidate;

    use InvalidArgumentException;

    class NewProdutos
    {
        public string $nome;
        public int $valor;
        public string $tipo;
        public int $id_img;
        public int $desconto;

        public function __construct(array $data)
        {
            if (empty($data["nome"])) {
                throw new InvalidArgumentException("O nome é obrigatório.");
            }
            if (empty($data["valor"])) {
                throw new InvalidArgumentException("O valor é obrigatório.");
            }
            if (empty($data["tipo"])) {
                throw new InvalidArgumentException("O tipo é obrigatório.");
            }
            if (empty($data["id_img"])) {
                throw new InvalidArgumentException("O id_img é obrigatório.");
            }
           
        
            $this->nome = $data["nome"];
            $this->valor = $data["valor"];
            $this->tipo = $data["tipo"];
            $this->id_img = $data["id_img"];
            $this->desconto = $data["desconto"];
        }
    }
    