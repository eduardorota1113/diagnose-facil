
<?php

require_once __DIR__ . '/../DAO/UsuarioDAO.php';
require_once __DIR__ . '/../DAO/DiagnosticoDAO.php';

class PainelController
{
    private PDO $conexao;

    public function __construct(PDO $conexao)
    {
        $this->conexao = $conexao;
    }

    private function contarRegistros(
        RepositorioInterface $repositorio
    ): int {
        return count($repositorio->listar());
    }

    public function obterResumo(): array
    {
        $usuarioDAO = new UsuarioDAO($this->conexao);
        $diagnosticoDAO = new DiagnosticoDAO($this->conexao);

        return [
            'usuarios' => $this->contarRegistros($usuarioDAO),
            'diagnosticos' => $this->contarRegistros($diagnosticoDAO)
        ];
    }
}
