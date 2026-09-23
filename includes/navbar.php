<?php
$paginaAtual = basename($_SERVER['PHP_SELF']);

function ativo(string $pagina, string $paginaAtual): string
{
    return $pagina === $paginaAtual ? 'active fw-bold' : '';
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="dashboard.php">Gestão de Produtos</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?= ativo('dashboard.php', $paginaAtual) ?>" href="dashboard.php">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ativo('produtos.php', $paginaAtual) ?>" href="produtos.php">Produtos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ativo('fornecedores.php', $paginaAtual) ?>" href="fornecedores.php">Fornecedores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ativo('selecionar_produtos.php', $paginaAtual) ?>" href="selecionar_produtos.php">Selecionar Produtos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ativo('cesta.php', $paginaAtual) ?>" href="cesta.php">Minha Cesta</a>
                </li>
            </ul>
            <span class="navbar-text text-light me-3">
                Olá, <strong><?= htmlspecialchars($_SESSION['usuario_nome'] ?? '') ?></strong>
            </span>
            <a href="auth/logout.php" class="btn btn-outline-light btn-sm">Sair</a>
        </div>
    </div>
</nav>