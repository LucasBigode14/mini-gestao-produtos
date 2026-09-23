<?php
require __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/classes/Produto.php';
require_once __DIR__ . '/classes/Fornecedor.php';
require_once __DIR__ . '/classes/Cesta.php';

$totalProdutos = count(Produto::listarTodos());
$totalFornecedores = count(Fornecedor::listarTodos());
$resumoCesta = Cesta::resumo((int) $_SESSION['usuario_id']);

$tituloPagina = 'Início';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/navbar.php';
?>

<div class="container">
    <h2 class="mb-4">Bem-vindo(a), <?= htmlspecialchars($_SESSION['usuario_nome']) ?>!</h2>
    
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Produtos cadastrados</h5>
                    <p class="display-6"><?= $totalProdutos ?></p>
                    <a href="produtos.php" class="btn btn-sm btn-outline-primary">Gerenciar</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Fornecedores cadastrados</h5>
                    <p class="display-6"><?= $totalFornecedores ?></p>
                    <a href="fornecedores.php" class="btn btn-sm btn-outline-primary">Gerenciar</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Itens na sua cesta</h5>
                    <p class="display-6"><?= $resumoCesta['quantidade_itens'] ?></p>
                    <a href="cesta.php" class="btn btn-sm btn-outline-primary">Ver cesta</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>