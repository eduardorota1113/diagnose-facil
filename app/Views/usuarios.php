
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DiagnoseFácil - Usuários</title>
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<header>
    <h1>DiagnoseFácil</h1>
    <p>Gerenciamento de usuários</p>
</header>

<main>
    <h2>Usuários cadastrados</h2>

    <p>
        <a href="?pagina=inicio">Início</a>
        |
        <a href="?pagina=diagnosticos">Diagnósticos</a>
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
        <h3>Cadastrar novo usuário</h3>

        <form method="post" action="?pagina=usuarios">

            <input type="hidden" name="acao" value="cadastrar">

            <input
                type="hidden"
                name="csrf_token"
                value="<?= htmlspecialchars($tokenCsrf, ENT_QUOTES, 'UTF-8') ?>"
            >

            <div class="campo">
                <label for="nome">Nome:</label>
                <input
                    type="text"
                    id="nome"
                    name="nome"
                    placeholder="Digite o nome"
                    maxlength="100"
                    required
                >
            </div>

            <div class="campo">
                <label for="email">E-mail:</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Digite o e-mail"
                    maxlength="150"
                    required
                >
            </div>

            <div class="campo">
                <label for="telefone">Telefone:</label>
                <input
                    type="tel"
                    id="telefone"
                    name="telefone"
                    placeholder="Digite o telefone (opcional)"
                    maxlength="20"
                >
            </div>

            <button type="submit">Cadastrar usuário</button>
        </form>
    </section>

    <?php if ($usuarioEdicao !== null): ?>

        <section class="cadastro-usuario">
            <h3>Editar usuário</h3>

            <form method="post" action="?pagina=usuarios">

                <input type="hidden" name="acao" value="atualizar">

                <input
                    type="hidden"
                    name="csrf_token"
                    value="<?= htmlspecialchars($tokenCsrf, ENT_QUOTES, 'UTF-8') ?>"
                >

                <input
                    type="hidden"
                    name="id_usuario"
                    value="<?= $usuarioEdicao->getIdUsuario() ?>"
                >

                <div class="campo">
                    <label for="editar_nome">Nome:</label>
                    <input
                        type="text"
                        id="editar_nome"
                        name="nome"
                        value="<?= htmlspecialchars($usuarioEdicao->getNome(), ENT_QUOTES, 'UTF-8') ?>"
                        maxlength="100"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="editar_email">E-mail:</label>
                    <input
                        type="email"
                        id="editar_email"
                        name="email"
                        value="<?= htmlspecialchars($usuarioEdicao->getEmail(), ENT_QUOTES, 'UTF-8') ?>"
                        maxlength="150"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="editar_telefone">Telefone:</label>
                    <input
                        type="tel"
                        id="editar_telefone"
                        name="telefone"
                        value="<?= htmlspecialchars($usuarioEdicao->getTelefone() ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        maxlength="20"
                    >
                </div>

                <button type="submit">Salvar alterações</button>

                <a href="?pagina=usuarios">Cancelar edição</a>
            </form>
        </section>

    <?php endif; ?>

    <?php if (empty($usuarios)): ?>

        <p>Nenhum usuário encontrado.</p>

    <?php else: ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= $usuario->getIdUsuario() ?></td>

                        <td>
                            <?= htmlspecialchars($usuario->getNome(), ENT_QUOTES, 'UTF-8') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($usuario->getEmail(), ENT_QUOTES, 'UTF-8') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($usuario->getTelefone() ?? '-', ENT_QUOTES, 'UTF-8') ?>
                        </td>

                        <td>
                            <a href="?pagina=usuarios&editar=<?= $usuario->getIdUsuario() ?>">
                                Editar
                            </a>

                            <form
                                method="post"
                                action="?pagina=usuarios"
                                style="display: inline;"
                                onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');"
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
                                    name="id_usuario"
                                    value="<?= $usuario->getIdUsuario() ?>"
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
