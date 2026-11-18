
<?php

class Conexao
{
    public static function conectar(): PDO
    {
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $porta = getenv('DB_PORT') ?: '3306';
        $banco = getenv('DB_NAME') ?: 'diagnose_facil';
        $usuario = getenv('DB_USER') ?: 'root';

        $senha = getenv('DB_PASSWORD');
        $senha = $senha === false ? '' : $senha;

        $dsn = "mysql:host=$host;port=$porta;dbname=$banco;charset=utf8mb4";

        return new PDO($dsn, $usuario, $senha, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
    }
}
