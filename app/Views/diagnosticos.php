
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DiagnoseFácil - Diagnósticos</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<header>
    <h1>DiagnoseFácil</h1>
    <p>Gerenciamento de diagnósticos</p>
</header>

<main>
    <h2>Diagnósticos cadastrados</h2>

    <p>
        <a href="?pagina=inicio">Início</a>
        |
        <a href="?pagina=usuarios">Usuários</a>
    </p>

    <?php if ($mensagemSucesso): ?>
        <p role="status">
            <?= htmlspecialchars($mensagemSucesso, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <?php if ($erroFormulario): ?>
        <p role="alert" style="color: #b42318;">
            <?= htmlspecialchars($erroFormulario, ENT_QUOTES, 'UTF-8') ?>
        </p>
    <?php endif; ?>

    <section class="cadastro-usuario">
        <h3>Cadastrar diagnóstico</h3>

        <form method="post" action="?pagina=diagnosticos">

            <input type="hidden" name="acao" value="cadastrar">

            <input
                type="hidden"
                name="csrf_token"
                value="<?= htmlspecialchars($tokenCsrf, ENT_QUOTES, 'UTF-8') ?>"
            >

            <div class="campo">
                <label for="id_usuario">Usuário:</label>

                <select id="id_usuario" name="id_usuario" required>
                    <option value="">Selecione um usuário</option>

                    <?php foreach ($usuarios as $usuario): ?>
                        <option value="<?= $usuario->getIdUsuario() ?>">
                            <?= htmlspecialchars($usuario->getNome(), ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="campo">
                <label for="descricao">Descrição do problema:</label>

                <textarea
                    id="descricao"
                    name="descricao"
                    rows="4"
                    required
                    placeholder="Descreva o problema encontrado"
                ></textarea>
            </div>

            <button type="submit">Cadastrar diagnóstico</button>
        </form>
    </section>

    <?php if ($diagnosticoEdicao !== null): ?>

        <section class="cadastro-usuario">
            <h3>Editar diagnóstico</h3>

            <form method="post" action="?pagina=diagnosticos">

                <input type="hidden" name="acao" value="atualizar">

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= htmlspecialchars($tokenCsrf, ENT_QUOTES, 'UTF-8') ?>"
                >

                <input
                    type="hidden"
                    name="id_diagnostico"
                    value="<?= $diagnosticoEdicao->getIdDiagnostico() ?>"
                >

                <div class="campo">
                    <label for="editar_usuario">Usuário:</label>

                    <select id="editar_usuario" name="id_usuario" required>
                        <?php foreach ($usuarios as $usuario): ?>

                            <option
                                value="<?= $usuario->getIdUsuario() ?>"
                                <?= $usuario->getIdUsuario() === $diagnosticoEdicao->getIdUsuario() ? 'selected' : '' ?>
                            >
                                <?= htmlspecialchars($usuario->getNome(), ENT_QUOTES, 'UTF-8') ?>
                            </option>

                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="campo">
                    <label for="editar_descricao">Descrição:</label>

                    <textarea
                        id="editar_descricao"
                        name="descricao"
                        rows="4"
                        required
                    ><?= htmlspecialchars(
                        $diagnosticoEdicao->getDescricao(),
                        ENT_QUOTES,
                        'UTF-8'
                    ) ?></textarea>
                </div>

                <button type="submit">Salvar alterações</button>

                <a href="?pagina=diagnosticos">Cancelar</a>
            </form>
        </section>

    <?php endif; ?>

    <?php if (empty($diagnosticos)): ?>

        <p>Nenhum diagnóstico encontrado.</p>

    <?php else: ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuário</th>
                    <th>Descrição</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($diagnosticos as $diagnostico): ?>
                    <tr>
                        <td><?= $diagnostico->getIdDiagnostico() ?></td>

                        <td><?= $diagnostico->getIdUsuario() ?></td>

                        <td>
                            <?= htmlspecialchars(
                                $diagnostico->getDescricao(),
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars(
                                $diagnostico->getDataDiagnostico() ?? '-',
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </td>

                        <td>
                            <a href="?pagina=diagnosticos&editar=<?= $diagnostico->getIdDiagnostico() ?>">
                                Editar
                            </a>

                            <form
                                method="post"
                                action="?pagina=diagnosticos"
                                style="display: inline;"
                                onsubmit="return confirm('Tem certeza que deseja excluir este diagnóstico?');"
                            >
                                <input
                                    type="hidden"
                                    name="acao"
                                    value="excluir"
                                >

                                <input
                                    type="hidden"
                                    name="csrf_token"
                                    value="<?= htmlspecialchars($tokenCsrf, ENT_QUOTES, 'UTF-8') ?>"
                                >

                                <input
                                    type="hidden"
                                    name="id_diagnostico"
                                    value="<?= $diagnostico->getIdDiagnostico() ?>"
                                >

                                <button type="submit">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>
</main>

<footer>
    <p>DiagnoseFácil - Projeto Acadêmico</p>
</footer>

</body>
</html>
