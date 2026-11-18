
<?php

require_once __DIR__ . '/../DAO/UsuarioDAO.php';

class UsuarioController
{
    private UsuarioDAO $usuarioDAO;

    public function __construct(PDO $conexao)
    {
        $this->usuarioDAO = new UsuarioDAO($conexao);
    }

    public function listar(): array
    {
        return $this->usuarioDAO->listar();
    }

public function cadastrar(
    string $nome,
    string $email,
    ?string $telefone = null
): int {
    $nome = trim($nome);
    $email = trim($email);
    $telefone = $telefone !== null ? trim($telefone) : null;

    if ($nome === '' || $email === '') {
        throw new InvalidArgumentException(
            "Nome e e-mail são obrigatórios."
        );
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException(
            "E-mail inválido."
        );
    }

    if ($telefone === '') {
        $telefone = null;
    }

    $usuario = new Usuario(
        null,
        $nome,
        $email,
        $telefone
    );

    return $this->usuarioDAO->cadastrar($usuario);
}

public function atualizar(
    int $idUsuario,
    string $nome,
    string $email,
    ?string $telefone = null
): bool {
    if ($idUsuario <= 0) {
        throw new InvalidArgumentException(
            "ID do usuário inválido."
        );
    }

    $nome = trim($nome);
    $email = trim($email);
    $telefone = $telefone !== null ? trim($telefone) : null;

    if ($nome === '' || $email === '') {
        throw new InvalidArgumentException(
            "Nome e e-mail são obrigatórios."
        );
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new InvalidArgumentException(
            "E-mail inválido."
        );
    }

    if ($telefone === '') {
        $telefone = null;
    }

    $usuario = new Usuario(
        $idUsuario,
        $nome,
        $email,
        $telefone
    );

    return $this->usuarioDAO->atualizar($usuario);
}

public function excluir(int $idUsuario): bool
{
    if ($idUsuario <= 0) {
        throw new InvalidArgumentException(
            "ID do usuário inválido."
        );
    }

    return $this->usuarioDAO->excluir($idUsuario);
}

}
