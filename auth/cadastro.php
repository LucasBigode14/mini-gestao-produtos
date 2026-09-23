<?php
require_once __DIR__ . '/../classes/Usuario.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$erro = null;
$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    $confirmarSenha = trim($_POST['confirmar_senha'] ?? '');

    if ($nome === '' || $email === '' || $senha === '') {
        $erro = 'Preencha todos os campos.';
    } elseif ($senha !== $confirmarSenha) {
        $erro = 'As senhas não coincidem.';
    } elseif (strlen($senha) < 4) {
        $erro = 'A senha deve ter ao menos 4 caracteres.';
    } else {
        try {
            Usuario::cadastrar($nome, $email, $senha);
            $sucesso = true;
        } catch (Exception $e) {
            $erro = $e->getMessage();
        }
    }
}

$tituloPagina = 'Cadastro';
require __DIR__ . '/../includes/header.php';
?>

<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h3 class="card-title text-center mb-4">Criar Conta</h3>

                    <?php if ($erro): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
                    <?php endif; ?>

                    <?php if ($sucesso): ?>
                        <div class="alert alert-success">
                            Conta criada com sucesso! <a href="../index.php">Clique aqui para entrar</a>.
                        </div>
                    <?php else: ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nome</label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Senha</label>
                                <input type="password" name="senha" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirmar Senha</label>
                                <input type="password" name="confirmar_senha" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                        </form>
                    <?php endif; ?>

                    <p class="text-center mt-3 mb-0">
                        <a href="../index.php">Voltar para o login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>