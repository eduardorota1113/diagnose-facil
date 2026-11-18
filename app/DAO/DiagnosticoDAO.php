
<?php

require_once __DIR__ . '/../Models/Diagnostico.php';
require_once __DIR__ . '/RepositorioInterface.php';

class DiagnosticoDAO implements RepositorioInterface
{
    private PDO $conexao;

    public function __construct(PDO $conexao)
    {
        $this->conexao = $conexao;
    }

    public function cadastrar(Diagnostico $diagnostico): int
    {
        $sql = "INSERT INTO diagnostico (id_usuario, descricao)
                VALUES (:id_usuario, :descricao)";

        $comando = $this->conexao->prepare($sql);

        $comando->execute([
            ':id_usuario' => $diagnostico->getIdUsuario(),
            ':descricao' => $diagnostico->getDescricao()
        ]);

        return (int) $this->conexao->lastInsertId();
    }

    public function listar(): array
    {
        $sql = "SELECT id_diagnostico,
                       id_usuario,
                       descricao,
                       data_diagnostico
                FROM diagnostico
                ORDER BY id_diagnostico";

        $comando = $this->conexao->query($sql);
        $diagnosticos = [];

        foreach ($comando->fetchAll() as $registro) {
            $diagnosticos[] = new Diagnostico(
                (int) $registro['id_diagnostico'],
                (int) $registro['id_usuario'],
                $registro['descricao'],
                $registro['data_diagnostico']
            );
        }

        return $diagnosticos;
    }

    public function atualizar(Diagnostico $diagnostico): bool
    {
        $id = $diagnostico->getIdDiagnostico();

        if ($id === null || $id <= 0) {
            throw new InvalidArgumentException(
                "ID do diagnóstico inválido."
            );
        }

        $sql = "UPDATE diagnostico
                SET id_usuario = :id_usuario,
                    descricao = :descricao
                WHERE id_diagnostico = :id";

        $comando = $this->conexao->prepare($sql);

        $comando->execute([
            ':id_usuario' => $diagnostico->getIdUsuario(),
            ':descricao' => $diagnostico->getDescricao(),
            ':id' => $id
        ]);

        return $comando->rowCount() > 0;
    }

    public function excluir(int $id): bool
    {
        if ($id <= 0) {
            throw new InvalidArgumentException(
                "ID do diagnóstico inválido."
            );
        }

        $comando = $this->conexao->prepare(
            "DELETE FROM diagnostico WHERE id_diagnostico = :id"
        );

        $comando->execute([':id' => $id]);

        return $comando->rowCount() > 0;
    }
}
