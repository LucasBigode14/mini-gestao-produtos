<?php
require __DIR__ . '/includes/auth_check.php';
$tituloPagina = 'Minha Cesta';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/navbar.php';
?>

<div class="container">
    <h2 class="mb-4">Minha Cesta de Compras</h2>
    <div id="alertaCesta"></div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title">Itens Selecionados</h5>
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Descrição</th>
                                <th>Preço</th>
                                <th class="text-end">Ação</th>
                            </tr>
                        </thead>
                        <tbody id="tabelaCestaItens">
                            <!-- Preenchido via AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Resumo da Cesta</h5>
                    <p class="d-flex justify-content-between">
                        <span>Quantidade de itens:</span>
                        <strong id="cestaQtdItens">0</strong>
                    </p>
                    <hr>
                    <p class="d-flex justify-content-between h5">
                        <span>Total:</span>
                        <strong class="text-success" id="cestaValorTotal">R$ 0,00</strong>
                    </p>
                    <a href="selecionar_produtos.php" class="btn btn-outline-primary w-100 mt-3">
                        Adicionar mais produtos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/cesta.js"></script>
</body>
</html>