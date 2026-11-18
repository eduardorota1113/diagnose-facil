
<?php

interface RepositorioInterface
{
    public function listar(): array;

    public function excluir(int $id): bool;
}
