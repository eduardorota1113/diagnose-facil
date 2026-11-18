
<?php

require_once __DIR__ . '/../DAO/DiagnosticoDAO.php';

class DiagnosticoController
{
    private DiagnosticoDAO $diagnosticoDAO;

    public function __construct(PDO $conexao)
    {
        $this->diagnosticoDAO = new DiagnosticoDAO($conexao);
    }

    public function listar(): array
    {
        return $this->diagnosticoDAO->listar();
    }

public function cadastrar(int $idUsuario, string $descricao): int
{
    if ($idUsuario <= 0) {
        throw new InvalidArgumentException(
            "ID do usuário inválido."
        );
    }

    $descricao = trim($descricao);

    if ($descricao === '') {
        throw new InvalidArgumentException(
            "A descrição do problema é obrigatória."
        );
    }

    $diagnostico = new Diagnostico(
        null,
        $idUsuario,
        $descricao
    );

    return $this->diagnosticoDAO->cadastrar($diagnostico);
}

public function atualizar(
    int $idDiagnostico,
    int $idUsuario,
    string $descricao
): bool {
    if ($idDiagnostico <= 0 || $idUsuario <= 0) {
        throw new InvalidArgumentException(
            "ID do diagnóstico ou do usuário inválido."
        );
    }

    $descricao = trim($descricao);

    if ($descricao === '') {
        throw new InvalidArgumentException(
            "A descrição do problema é obrigatória."
        );
    }

    $diagnostico = new Diagnostico(
        $idDiagnostico,
        $idUsuario,
        $descricao
    );

    return $this->diagnosticoDAO->atualizar($diagnostico);
}

public function excluir(int $idDiagnostico): bool
{
    if ($idDiagnostico <= 0) {
        throw new InvalidArgumentException(
            "ID do diagnóstico inválido."
        );
    }

    return $this->diagnosticoDAO->excluir($idDiagnostico);
}

}
