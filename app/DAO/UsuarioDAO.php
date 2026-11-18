
<?php

require_once __DIR__ . '/../Models/Usuario.php';
require_once __DIR__ . '/RepositorioInterface.php';

class UsuarioDAO implements RepositorioInterface
{
    private PDO $conexao;

    public function __construct(PDO $conexao)
    {
        $this->conexao = $conexao;
    }

    public function cadastrar(Usuario $usuario): int
    {
        $sql = "INSERT INTO usuario (nome, email, telefone)
                VALUES (:nome, :email, :telefone)";

        $comando = $this->conexao->prepare($sql);

        $comando->execute([
            ':nome' => $usuario->getNome(),
            ':email' => $usuario->getEmail(),
            ':telefone' => $usuario->getTelefone()
        ]);

        return (int) $this->conexao->lastInsertId();
    }

    public function listar(): array
    {
        $sql = "SELECT id_usuario, nome, email, telefone
                FROM usuario
                ORDER BY id_usuario";

        $comando = $this->conexao->query($sql);
        $usuarios = [];

        foreach ($comando->fetchAll() as $registro) {
            $usuarios[] = new Usuario(
                (int) $registro['id_usuario'],
                $registro['nome'],
                $registro['email'],
                $registro['telefone']
            );
        }

        return $usuarios;
    }

    public function atualizar(Usuario $usuario): bool
    {
        $id = $usuario->getIdUsuario();

        if ($id === null || $id <= 0) {
            throw new InvalidArgumentException(
                "ID do usuário inválido."
            );
        }

        $sql = "UPDATE usuario
                SET nome = :nome,
                    email = :email,
                    telefone = :telefone
                WHERE id_usuario = :id";

        $comando = $this->conexao->prepare($sql);

        $comando->execute([
            ':nome' => $usuario->getNome(),
            ':email' => $usuario->getEmail(),
            ':telefone' => $usuario->getTelefone(),
            ':id' => $id
        ]);

        return $comando->rowCount() > 0;
    }

    public function excluir(int $id): bool
    {
        if ($id <= 0) {
            throw new InvalidArgumentException(
                "ID do usuário inválido."
            );
        }

        $comando = $this->conexao->prepare(
            "DELETE FROM usuario WHERE id_usuario = :id"
        );

        $comando->execute([':id' => $id]);

        return $comando->rowCount() > 0;
    }
}
