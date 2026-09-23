<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../classes/Cesta.php';

header('Content-Type: application/json; charset=utf-8');

$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';
$usuarioId = (int) $_SESSION['usuario_id'];

try {
    switch ($acao) {
        case 'adicionar':
            $produtosSelecionados = $_POST['produtos'] ?? [];
            if (!is_array($produtosSelecionados) || count($produtosSelecionados) === 0) {
                throw new Exception('Selecione ao menos um produto antes de adicionar à cesta.');
            }
            $qtdAdicionada = Cesta::adicionarProdutos($usuarioId, $produtosSelecionados);
            echo json_encode([
                'sucesso' => true,
                'mensagem' => $qtdAdicionada . ' produto(s) adicionado(s) à cesta!'
            ]);
            break;

        case 'remover':
            Cesta::removerProduto($usuarioId, (int) $_POST['produto_id']);
            echo json_encode(['sucesso' => true, 'mensagem' => 'Produto removido da cesta.']);
            break;

        case 'resumo':
            echo json_encode(['sucesso' => true, 'dados' => Cesta::resumo($usuarioId)]);
            break;

        default:
            http_response_code(400);
            echo json_encode(['sucesso' => false, 'mensagem' => 'Ação inválida.']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['sucesso' => false, 'mensagem' => $e->getMessage()]);
}