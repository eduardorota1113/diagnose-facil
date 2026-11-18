
<?php

session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    'secure' => !empty($_SERVER['HTTPS'])
        && $_SERVER['HTTPS'] !== 'off'
]);

session_start();

require_once __DIR__ . '/../app/Config/Conexao.php';

if (
    !isset($_SESSION['csrf_token']) ||
    !is_string($_SESSION['csrf_token'])
) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$tokenCsrf = $_SESSION['csrf_token'];

$mensagemSucesso = $_SESSION['mensagem_sucesso'] ?? null;
unset($_SESSION['mensagem_sucesso']);

$erroFormulario = null;
$pagina = $_GET['pagina'] ?? 'inicio';

function validarCsrf(): void
{
    $tokenRecebido = $_POST['csrf_token'] ?? null;

    if (
        !is_string($tokenRecebido) ||
        !hash_equals($_SESSION['csrf_token'], $tokenRecebido)
    ) {
        throw new InvalidArgumentException(
            'Formulário inválido. Atualize a página e tente novamente.'
        );
    }
}

function obterIdPost(string $campo): int
{
    $id = filter_input(
        INPUT_POST,
        $campo,
        FILTER_VALIDATE_INT
    );

    if (!is_int($id) || $id <= 0) {
        throw new InvalidArgumentException(
            'Identificador inválido.'
        );
    }

    return $id;
}

if ($pagina === 'usuarios') {

    try {
        require_once __DIR__ . '/../app/Controllers/UsuarioController.php';

        $conexao = Conexao::conectar();
        $controller = new UsuarioController($conexao);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {
                validarCsrf();

                $acao = $_POST['acao'] ?? '';

                if ($acao === 'cadastrar') {

                    $controller->cadastrar(
                        $_POST['nome'] ?? '',
                        $_POST['email'] ?? '',
                        $_POST['telefone'] ?? null
                    );

                    $mensagem = 'Usuário cadastrado com sucesso!';

                } elseif ($acao === 'atualizar') {

                    $id = obterIdPost('id_usuario');

                    $atualizado = $controller->atualizar(
                        $id,
                        $_POST['nome'] ?? '',
                        $_POST['email'] ?? '',
                        $_POST['telefone'] ?? null
                    );

                    if (!$atualizado) {
                        throw new InvalidArgumentException(
                            'Nenhuma alteração foi realizada.'
                        );
                    }

                    $mensagem = 'Usuário atualizado com sucesso!';

                } elseif ($acao === 'excluir') {

                    $id = obterIdPost('id_usuario');

                    require_once __DIR__ .
                        '/../app/Controllers/DiagnosticoController.php';

                    $diagnosticoController =
                        new DiagnosticoController($conexao);

                    foreach ($diagnosticoController->listar() as $diagnostico) {
                        if ($diagnostico->getIdUsuario() === $id) {
                            throw new InvalidArgumentException(
                                'Este usuário possui diagnósticos e não pode ser excluído.'
                            );
                        }
                    }

                    if (!$controller->excluir($id)) {
                        throw new InvalidArgumentException(
                            'Usuário não encontrado.'
                        );
                    }

                    $mensagem = 'Usuário excluído com sucesso!';

                } else {
                    throw new InvalidArgumentException(
                        'Operação inválida.'
                    );
                }

                $_SESSION['mensagem_sucesso'] = $mensagem;

                header('Location: ?pagina=usuarios', true, 303);
                exit;

            } catch (InvalidArgumentException $erro) {
                $erroFormulario = $erro->getMessage();

            } catch (PDOException $erro) {
                $erroFormulario = $erro->getCode() === '23000'
                    ? 'E-mail já cadastrado ou relacionamento inválido.'
                    : 'Erro no banco de dados.';

            } catch (Throwable $erro) {
                $erroFormulario = 'Não foi possível concluir a operação.';
            }
        }

        $usuarios = $controller->listar();

        $usuarioEdicao = null;

        $idEdicao = filter_input(
            INPUT_GET,
            'editar',
            FILTER_VALIDATE_INT
        );

        if (is_int($idEdicao) && $idEdicao > 0) {
            foreach ($usuarios as $usuario) {
                if ($usuario->getIdUsuario() === $idEdicao) {
                    $usuarioEdicao = $usuario;
                    break;
                }
            }
        }

        require __DIR__ . '/../app/Views/usuarios.php';

    } catch (Throwable $erro) {
        http_response_code(500);
        echo 'Erro ao carregar os usuários.';
    }

} elseif ($pagina === 'diagnosticos') {

    try {
        require_once __DIR__ .
            '/../app/Controllers/DiagnosticoController.php';

        require_once __DIR__ .
            '/../app/Controllers/UsuarioController.php';

        $conexao = Conexao::conectar();

        $controller = new DiagnosticoController($conexao);
        $usuarioController = new UsuarioController($conexao);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            try {
                validarCsrf();

                $acao = $_POST['acao'] ?? '';

                if ($acao === 'cadastrar') {

                    $controller->cadastrar(
                        obterIdPost('id_usuario'),
                        $_POST['descricao'] ?? ''
                    );

                    $mensagem = 'Diagnóstico cadastrado com sucesso!';

                } elseif ($acao === 'atualizar') {

                    $atualizado = $controller->atualizar(
                        obterIdPost('id_diagnostico'),
                        obterIdPost('id_usuario'),
                        $_POST['descricao'] ?? ''
                    );

                    if (!$atualizado) {
                        throw new InvalidArgumentException(
                            'Nenhuma alteração foi realizada.'
                        );
                    }

                    $mensagem = 'Diagnóstico atualizado com sucesso!';

                } elseif ($acao === 'excluir') {

                    if (
                        !$controller->excluir(
                            obterIdPost('id_diagnostico')
                        )
                    ) {
                        throw new InvalidArgumentException(
                            'Diagnóstico não encontrado.'
                        );
                    }

                    $mensagem = 'Diagnóstico excluído com sucesso!';

                } else {
                    throw new InvalidArgumentException(
                        'Operação inválida.'
                    );
                }

                $_SESSION['mensagem_sucesso'] = $mensagem;

                header('Location: ?pagina=diagnosticos', true, 303);
                exit;

            } catch (InvalidArgumentException $erro) {
                $erroFormulario = $erro->getMessage();

            } catch (PDOException $erro) {
                $erroFormulario = 'Não foi possível salvar os dados no banco.';

            } catch (Throwable $erro) {
                $erroFormulario = 'Não foi possível concluir a operação.';
            }
        }

        $diagnosticos = $controller->listar();
        $usuarios = $usuarioController->listar();

        $diagnosticoEdicao = null;

        $idEdicao = filter_input(
            INPUT_GET,
            'editar',
            FILTER_VALIDATE_INT
        );

        if (is_int($idEdicao) && $idEdicao > 0) {
            foreach ($diagnosticos as $diagnostico) {
                if ($diagnostico->getIdDiagnostico() === $idEdicao) {
                    $diagnosticoEdicao = $diagnostico;
                    break;
                }
            }
        }

        require __DIR__ . '/../app/Views/diagnosticos.php';

    } catch (Throwable $erro) {
        http_response_code(500);
        echo 'Erro ao carregar os diagnósticos.';
    }

} else {

    try {
        require_once __DIR__ .
            '/../app/Controllers/PainelController.php';

        $conexao = Conexao::conectar();

        $painelController = new PainelController($conexao);

        $resumo = $painelController->obterResumo();

        require __DIR__ . '/../app/Views/inicio.php';

    } catch (Throwable $erro) {
        http_response_code(500);
        echo 'Erro ao carregar a página inicial.';
    }
}
