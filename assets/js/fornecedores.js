const URL_AJAX_FORNECEDOR = 'ajax/fornecedor_ajax.php';

async function carregarFornecedores() {
    const resposta = await fetch(URL_AJAX_FORNECEDOR, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'acao=listar'
    });
    const json = await resposta.json();
    const tabela = document.getElementById('tabelaFornecedores');
    tabela.innerHTML = '';

    if (!json.sucesso || json.dados.length === 0) {
        tabela.innerHTML = '<tr><td colspan="5" class="text-center text-muted">Nenhum fornecedor cadastrado ainda.</td></tr>';
        return;
    }

    json.dados.forEach((fornecedor) => {
        const linha = document.createElement('tr');
        linha.innerHTML = `
            <td>${fornecedor.nome}</td>
            <td>${fornecedor.cnpj}</td>
            <td>${fornecedor.telefone ?? ''}</td>
            <td>${fornecedor.email ?? ''}</td>
            <td class="text-end">
                <button class="btn btn-sm btn-outline-primary" onclick="editarFornecedor(${fornecedor.id})">Editar</button>
                <button class="btn btn-sm btn-outline-danger" onclick="excluirFornecedor(${fornecedor.id})">Excluir</button>
            </td>
        `;
        tabela.appendChild(linha);
    });

    window.fornecedoresCache = json.dados;
}

function mostrarAlerta(idContainer, tipo, mensagem) {
    const container = document.getElementById(idContainer);
    container.innerHTML = `<div class="alert alert-${tipo}">${mensagem}</div>`;
    setTimeout(() => (container.innerHTML = ''), 3000);
}

document.getElementById('formFornecedor').addEventListener('submit', async (evento) => {
    evento.preventDefault();
    const id = document.getElementById('fornecedor_id').value;
    const acao = id ? 'editar' : 'criar';

    const parametros = new URLSearchParams();
    parametros.append('acao', acao);
    if (id) parametros.append('id', id);
    parametros.append('nome', document.getElementById('fornecedor_nome').value);
    parametros.append('cnpj', document.getElementById('fornecedor_cnpj').value);
    parametros.append('telefone', document.getElementById('fornecedor_telefone').value);
    parametros.append('email', document.getElementById('fornecedor_email').value);

    const resposta = await fetch(URL_AJAX_FORNECEDOR, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: parametros.toString()
    });
    const json = await resposta.json();

    if (json.sucesso) {
        mostrarAlerta('alertaFornecedor', 'success', json.mensagem);
        document.getElementById('formFornecedor').reset();
        document.getElementById('fornecedor_id').value = '';
        document.getElementById('tituloFormFornecedor').textContent = 'Novo Fornecedor';
        document.getElementById('btnCancelarEdicaoFornecedor').classList.add('d-none');
        carregarFornecedores();
    } else {
        mostrarAlerta('alertaFornecedor', 'danger', json.mensagem);
    }
});

function editarFornecedor(id) {
    const fornecedor = window.fornecedoresCache.find((f) => f.id == id);
    if (!fornecedor) return;

    document.getElementById('fornecedor_id').value = fornecedor.id;
    document.getElementById('fornecedor_nome').value = fornecedor.nome;
    document.getElementById('fornecedor_cnpj').value = fornecedor.cnpj;
    document.getElementById('fornecedor_telefone').value = fornecedor.telefone ?? '';
    document.getElementById('fornecedor_email').value = fornecedor.email ?? '';
    document.getElementById('tituloFormFornecedor').textContent = 'Editar Fornecedor';
    document.getElementById('btnCancelarEdicaoFornecedor').classList.remove('d-none');
}

document.getElementById('btnCancelarEdicaoFornecedor').addEventListener('click', () => {
    document.getElementById('formFornecedor').reset();
    document.getElementById('fornecedor_id').value = '';
    document.getElementById('tituloFormFornecedor').textContent = 'Novo Fornecedor';
    document.getElementById('btnCancelarEdicaoFornecedor').classList.add('d-none');
});

async function excluirFornecedor(id) {
    if (!confirm('Tem certeza que deseja excluir este fornecedor? Os produtos ligados a ele também serão excluídos.')) {
        return;
    }

    const parametros = new URLSearchParams();
    parametros.append('acao', 'excluir');
    parametros.append('id', id);

    const resposta = await fetch(URL_AJAX_FORNECEDOR, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: parametros.toString()
    });
    const json = await resposta.json();

    if (json.sucesso) {
        mostrarAlerta('alertaFornecedor', 'success', json.mensagem);
        carregarFornecedores();
    } else {
        mostrarAlerta('alertaFornecedor', 'danger', json.mensagem);
    }
}

document.addEventListener('DOMContentLoaded', carregarFornecedores);