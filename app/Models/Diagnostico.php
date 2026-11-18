
<?php

class Diagnostico
{
    private ?int $idDiagnostico;
    private int $idUsuario;
    private string $descricao;
    private ?string $dataDiagnostico;

    public function __construct(
        ?int $idDiagnostico,
        int $idUsuario,
        string $descricao,
        ?string $dataDiagnostico = null
    ) {
        $this->idDiagnostico = $idDiagnostico;
        $this->idUsuario = $idUsuario;
        $this->descricao = $descricao;
        $this->dataDiagnostico = $dataDiagnostico;
    }

    public function getIdDiagnostico(): ?int
    {
        return $this->idDiagnostico;
    }

    public function getIdUsuario(): int
    {
        return $this->idUsuario;
    }

    public function setIdUsuario(int $idUsuario): void
    {
        $this->idUsuario = $idUsuario;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): void
    {
        $this->descricao = $descricao;
    }

    public function getDataDiagnostico(): ?string
    {
        return $this->dataDiagnostico;
    }
}
