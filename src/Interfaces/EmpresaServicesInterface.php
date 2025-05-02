<?php
    namespace App\Interfaces;

    interface EmpresaServicesInterface
    {
        public function pegarEmpresa(): array;
        public function pegarEmpresaOne(int $id): array;
        public function inserirEmpresa(array $body, mixed $auth): array;
        public function updateEmpresa(array $body, mixed $auth): array;
        public function desativaEmpresa(array $data, mixed $auth): array;
        public function ativaEmpresa(array $data, mixed $auth): array;
    }