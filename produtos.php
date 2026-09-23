<?php
require __DIR__ . '/includes/auth_check.php';
require_once __DIR__ . '/classes/Fornecedor.php';

$fornecedores = Fornecedor::listarTodos();
$tituloPagina = 'Produtos';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/navbar.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title" id="tituloFormProduto">Novo Produto</h5>
                    <div id="alertaProduto"></div>
                    <?php if (empty($fornecedores)): ?>
                        <div class="alert alert-warning">
                            Cadastre um <a href="fornecedores.php">fornecedor</a> antes de cadastrar produtos.
                        </div>
                    <?php else: ?>
                        <form id="formProduto">
                            <input type="hidden" id="produto_id" value="">
                            <div class="mb-2">
                                <label class="form-label">Nome</label>
                                <input type="text" id="produto_nome" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Descrição</label>
                                <input type="text" id="produto_descricao" class="form-control">
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Preço (R$)</label>
                                <input type="number" step="0.01" min="0" id="produto_preco" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Fornecedor</label>
                                <select id="produto_fornecedor" class="form-select" required>
                                    <option value="">Selecione...</option>
                                    <?php foreach ($fornecedores as $f): ?>
                                        <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['nome']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-2">Salvar</button>
                            <button type="button" id="btnCancelarEdicaoProduto" class="btn btn-secondary w-100 mt-2 d-none">
                                Cancelar edição
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Produtos cadastrados</h5>
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Preço</th>
                                <th>Fornecedor</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="tabelaProdutos">
                            <!-- Preenchido via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/produtos.js"></script>
</body>
</html>