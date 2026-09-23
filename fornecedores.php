<?php
require __DIR__ . '/includes/auth_check.php';
$tituloPagina = 'Fornecedores';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/navbar.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title" id="tituloFormFornecedor">Novo Fornecedor</h5>
                    <div id="alertaFornecedor"></div>
                    <form id="formFornecedor">
                        <input type="hidden" id="fornecedor_id" value="">
                        <div class="mb-2">
                            <label class="form-label">Nome</label>
                            <input type="text" id="fornecedor_nome" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">CNPJ</label>
                            <input type="text" id="fornecedor_cnpj" class="form-control" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Telefone</label>
                            <input type="text" id="fornecedor_telefone" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">E-mail</label>
                            <input type="email" id="fornecedor_email" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-2">Salvar</button>
                        <button type="button" id="btnCancelarEdicaoFornecedor" class="btn btn-secondary w-100 mt-2 d-none">
                            Cancelar edição
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Fornecedores cadastrados</h5>
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>CNPJ</th>
                                <th>Telefone</th>
                                <th>E-mail</th>
                                <th class="text-end">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="tabelaFornecedores">
                            <!-- Preenchido via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/fornecedores.js"></script>
</body>
</html>