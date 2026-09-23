<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../classes/Fornecedor.php';

header('Content-Type: application/json; charset=utf-8');

$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';

try {
    switch ($acao) {
        case 'listar':
            echo json_encode(['sucesso' => true, 'dados' => Fornecedor::listarTodos()]);
            break;

        case 'criar':
            $fornecedor = new Fornecedor(
                trim($_POST['nome'] ?? ''),
                trim($_POST['cnpj'] ?? ''),
                trim($_POST['telefone'] ?? ''),
                trim($_POST['email'] ?? '')
            );
            $fornecedor->salvar();
            echo json_encode(['sucesso' => true, 'mensagem' => 'Fornecedor cadastrado com sucesso!']);
            break;

        case 'editar':
            Fornecedor::atualizar(
                (int) $_POST['id'],
                trim($_POST['nome'] ?? ''),
                trim($_POST['cnpj'] ?? ''),
                trim($_POST['telefone'] ?? ''),
                trim($_POST['email'] ?? '')
            );
            echo json_encode(['sucesso' => true, 'mensagem' => 'Fornecedor atualizado com sucesso!']);
            break;

        case 'excluir':
            Fornecedor::excluir((int) $_POST['id']);
            echo json_encode(['sucesso' => true, 'mensagem' => 'Fornecedor excluído com sucesso!']);
            break;

        default:
            http_response_code(400);
            echo json_encode(['sucesso' => false, 'mensagem' => 'Ação inválida.']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['sucesso' => false, 'mensagem' => $e->getMessage()]);
}