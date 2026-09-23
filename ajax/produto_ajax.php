<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../classes/Produto.php';

header('Content-Type: application/json; charset=utf-8');

$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';

try {
    switch ($acao) {
        case 'listar':
            echo json_encode(['sucesso' => true, 'dados' => Produto::listarTodos()]);
            break;

        case 'criar':
            $produto = new Produto(
                trim($_POST['nome'] ?? ''),
                trim($_POST['descricao'] ?? ''),
                (float) ($_POST['preco'] ?? 0),
                (int) ($_POST['fornecedor_id'] ?? 0)
            );
            $produto->salvar();
            echo json_encode(['sucesso' => true, 'mensagem' => 'Produto cadastrado com sucesso!']);
            break;

        case 'editar':
            Produto::atualizar(
                (int) $_POST['id'],
                trim($_POST['nome'] ?? ''),
                trim($_POST['descricao'] ?? ''),
                (float) ($_POST['preco'] ?? 0),
                (int) ($_POST['fornecedor_id'] ?? 0)
            );
            echo json_encode(['sucesso' => true, 'mensagem' => 'Produto atualizado com sucesso!']);
            break;

        case 'excluir':
            Produto::excluir((int) $_POST['id']);
            echo json_encode(['sucesso' => true, 'mensagem' => 'Produto excluído com sucesso!']);
            break;

        default:
            http_response_code(400);
            echo json_encode(['sucesso' => false, 'mensagem' => 'Ação inválida.']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['sucesso' => false, 'mensagem' => $e->getMessage()]);
}