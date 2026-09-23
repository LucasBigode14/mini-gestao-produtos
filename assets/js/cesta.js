const URL_AJAX_CESTA = 'ajax/cesta_ajax.php';

function formatarMoeda(valor) {
    return Number(valor).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
}

function mostrarAlertaCesta(tipo, mensagem) {
    const container = document.getElementById('alertaCesta');
    if (container) {
        container.innerHTML = `<div class="alert alert-${tipo}">${mensagem}</div>`;
        setTimeout(() => (container.innerHTML = ''), 3000);
    }
}

const formSelecionarProdutos = document.getElementById('formSelecionarProdutos');
if (formSelecionarProdutos) {
    formSelecionarProdutos.addEventListener('submit', async (evento) => {
        evento.preventDefault();

        const checkboxes = document.querySelectorAll('input[name="produtos[]"]:checked');
        const produtos = Array.from(checkboxes).map((cb) => cb.value);

        if (produtos.length === 0) {
            mostrarAlertaCesta('warning', 'Selecione pelo menos um produto para incluir na cesta.');
            return;
        }

        const parametros = new URLSearchParams();
        parametros.append('acao', 'adicionar');
        produtos.forEach((id) => parametros.append('produtos[]', id));

        const resposta = await fetch(URL_AJAX_CESTA, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: parametros.toString()
        });
        const json = await resposta.json();

        if (json.sucesso) {
            mostrarAlertaCesta('success', json.mensagem);
            checkboxes.forEach((cb) => (cb.checked = false));
        } else {
            mostrarAlertaCesta('danger', json.mensagem);
        }
    });
}

async function carregarResumoCesta() {
    const tabela = document.getElementById('tabelaCestaItens');
    if (!tabela) return;

    const resposta = await fetch(URL_AJAX_CESTA, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'acao=resumo'
    });
    const json = await resposta.json();

    tabela.innerHTML = '';

    if (!json.sucesso || json.dados.produtos.length === 0) {
        tabela.innerHTML = '<tr><td colspan="4" class="text-center text-muted">Sua cesta está vazia.</td></tr>';
        document.getElementById('cestaQtdItens').textContent = '0';
        document.getElementById('cestaValorTotal').textContent = formatarMoeda(0);
        return;
    }

    json.dados.produtos.forEach((produto) => {
        const linha = document.createElement('tr');
        linha.innerHTML = `
            <td>${produto.nome}</td>
            <td>${produto.descricao ?? ''}</td>
            <td>${formatarMoeda(produto.preco)}</td>
            <td class="text-end">
                <button class="btn btn-sm btn-outline-danger" onclick="removerDoCarrinho(${produto.id})">Remover</button>
            </td>
        `;
        tabela.appendChild(linha);
    });

    document.getElementById('cestaQtdItens').textContent = json.dados.quantidade_itens;
    document.getElementById('cestaValorTotal').textContent = formatarMoeda(json.dados.valor_total);
}

async function removerDoCarrinho(produtoId) {
    const parametros = new URLSearchParams();
    parametros.append('acao', 'remover');
    parametros.append('produto_id', produtoId);

    const resposta = await fetch(URL_AJAX_CESTA, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: parametros.toString()
    });
    const json = await resposta.json();

    if (json.sucesso) {
        carregarResumoCesta();
    } else {
        mostrarAlertaCesta('danger', json.mensagem);
    }
}

document.addEventListener('DOMContentLoaded', carregarResumoCesta);