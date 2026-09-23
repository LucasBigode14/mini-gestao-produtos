<?php
require __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/classes/Produto.php';

$produtos = Produto::listarTodos();
$tituloPagina = 'Selecionar Produtos';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/navbar.php';
?>

<div class="container">
    <h2 class="mb-4">Selecionar Produtos para a Cesta</h2>
    <div id="alertaCesta"></div>

    <div class="card shadow-sm">
        <div class="card-body">
            <?php if (empty($produtos)): ?>
                <div class="alert alert-info mb-0">
                    Nenhum produto cadastrado ainda. Cadastre produtos na tela de <a href="produtos.php">Produtos</a>.
                </div>
            <?php else: ?>
                <form id="formSelecionarProdutos">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th style="width: 40px;">#</th>
                                <th>Produto</th>
                                <th>Descrição</th>
                                <th>Preço</th>
                                <th>Fornecedor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produtos as $p): ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="produtos[]" value="<?= $p['id'] ?>" class="form-check-input">
                                    </td>
                                    <td><?= htmlspecialchars($p['nome']) ?></td>
                                    <td><?= htmlspecialchars($p['descricao'] ?? '') ?></td>
                                    <td>R$ <?= number_format($p['preco'], 2, ',', '.') ?></td>
                                    <td><?= htmlspecialchars($p['fornecedor_nome']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-success mt-2">
                        Adicionar Selecionados à Cesta
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/cesta.js"></script>
</body>
</html>