
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>DiagnoseFácil - Início</title>

    <link rel="stylesheet" href="css/estilo.css">

    <style>
        .resumo-painel {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 30px;
        }

        .resumo-item {
            background: #f3f6fb;
            border-radius: 10px;
            padding: 25px;
            flex: 1;
            min-width: 180px;
        }

        .resumo-item strong {
            display: block;
            color: #173b63;
            font-size: 36px;
            margin-bottom: 10px;
        }

        .menu-inicio {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 30px;
        }

        .menu-inicio a {
            display: inline-block;
            background: #173b63;
            color: white;
            padding: 14px 22px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
        }

        .menu-inicio a:hover {
            background: #24588e;
        }
    </style>
</head>

<body>

    <header>
        <h1>DiagnoseFácil</h1>
        <p>Sistema de gerenciamento de diagnósticos</p>
    </header>

    <main>
        <h2>Bem-vindo ao DiagnoseFácil!</h2>

        <p>
            Organize usuários e registre problemas
            encontrados em sua residência.
        </p>

        <div class="resumo-painel">

            <div class="resumo-item">
                <strong><?= (int) $resumo['usuarios'] ?></strong>
                <span>Usuários cadastrados</span>
            </div>

            <div class="resumo-item">
                <strong><?= (int) $resumo['diagnosticos'] ?></strong>
                <span>Diagnósticos cadastrados</span>
            </div>

        </div>

        <nav class="menu-inicio" aria-label="Menu principal">

            <a href="?pagina=usuarios">
                Gerenciar usuários
            </a>

            <a href="?pagina=diagnosticos">
                Gerenciar diagnósticos
            </a>

        </nav>

    </main>

    <footer>
        <p>DiagnoseFácil - Projeto Acadêmico</p>
    </footer>

</body>
</html>
