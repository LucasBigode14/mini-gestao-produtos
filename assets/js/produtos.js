const URL_AJAX_PRODUTO = 'ajax/produto_ajax.php';

function formatarMoeda(valor) {
    return Number(valor).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
}

async function carregarProdutos() {
    const resposta = await fetch(URL_AJAX_PRODUTO, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'acao=listar'
    });
    const json = await resposta.json();
    const tabela = document.getElementById('tabelaProdutos');
    tabela.innerHTML = '';

    if (!json.sucesso || json.dados.length === 0) {
        tabela.innerHTML = '<tr><td colspan="5" class="text-center text-muted">Nenhum produto cadastrado ainda.</td></tr>';
        return;
    }

    json.dados.forEach((produto) => {
        const linha = document.createElement('tr');
        linha.innerHTML = `
            <td>${produto.nome}</td>
            <td>${produto.descricao ?? ''}</td>
            <td>${formatarMoeda(produto.preco)}</td>
            <td>${produto.fornecedor_nome}</td>
            <td class="text-end">
                <button class="btn btn-sm btn-outline-primary" onclick="editarProduto(${produto.id})">Editar</button>
                <button class="btn btn-sm btn-outline-danger" onclick="excluirProduto(${produto.id})">Excluir</button>
            </td>
        `;
        tabela.appendChild(linha);
    });

    window.produtosCache = json.dados;
}

function mostrarAlertaProduto(tipo, mensagem) {
    const container = document.getElementById('alertaProduto');
    container.innerHTML = `<div class="alert alert-${tipo}">${mensagem}</div>`;
    setTimeout(() => (container.innerHTML = ''), 3000);
}

const formProduto = document.getElementById('formProduto');
if (formProduto) {
    formProduto.addEventListener('submit', async (evento) => {
        evento.preventDefault();
        const id = document.getElementById('produto_id').value;
        const acao = id ? 'editar' : 'criar';

        const parametros = new URLSearchParams();
        parametros.append('acao', acao);
        if (id) parametros.append('id', id);
        parametros.append('nome', document.getElementById('produto_nome').value);
        parametros.append('descricao', document.getElementById('produto_descricao').value);
        parametros.append('preco', document.getElementById('produto_preco').value);
        parametros.append('fornecedor_id', document.getElementById('produto_fornecedor').value);

        const resposta = await fetch(URL_AJAX_PRODUTO, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: parametros.toString()
        });
        const json = await resposta.json();

        if (json.sucesso) {
            mostrarAlertaProduto('success', json.mensagem);
            formProduto.reset();
            document.getElementById('produto_id').value = '';
            document.getElementById('tituloFormProduto').textContent = 'Novo Produto';
            document.getElementById('btnCancelarEdicaoProduto').classList.add('d-none');
            carregarProdutos();
        } else {
            mostrarAlertaProduto('danger', json.mensagem);
        }
    });

    document.getElementById('btnCancelarEdicaoProduto').addEventListener('click', () => {
        formProduto.reset();
        document.getElementById('produto_id').value = '';
        document.getElementById('tituloFormProduto').textContent = 'Novo Produto';
        document.getElementById('btnCancelarEdicaoProduto').classList.add('d-none');
    });
}

function editarProduto(id) {
    const produto = window.produtosCache.find((p) => p.id == id);
    if (!produto) return;

    document.getElementById('produto_id').value = produto.id;
    document.getElementById('produto_nome').value = produto.nome;
    document.getElementById('produto_descricao').value = produto.descricao ?? '';
    document.getElementById('produto_preco').value = produto.preco;
    document.getElementById('produto_fornecedor').value = produto.fornecedor_id;
    document.getElementById('tituloFormProduto').textContent = 'Editar Produto';
    document.getElementById('btnCancelarEdicaoProduto').classList.remove('d-none');
}

async function excluirProduto(id) {
    if (!confirm('Tem certeza que deseja excluir este produto?')) return;

    const parametros = new URLSearchParams();
    parametros.append('acao', 'excluir');
    parametros.append('id', id);

    const resposta = await fetch(URL_AJAX_PRODUTO, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: parametros.toString()
    });
    const json = await resposta.json();

    if (json.sucesso) {
        mostrarAlertaProduto('success', json.mensagem);
        carregarProdutos();
    } else {
        mostrarAlertaProduto('danger', json.mensagem);
    }
}

document.addEventListener('DOMContentLoaded', carregarProdutos);