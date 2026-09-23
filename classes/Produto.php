<?php
require_once __DIR__ . '/../config/database.php';

class Produto
{
    private ?int $id;
    private string $nome;
    private string $descricao;
    private float $preco;
    private int $fornecedorId;

    public function __construct(
        string $nome = '',
        string $descricao = '',
        float $preco = 0.0,
        int $fornecedorId = 0,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->fornecedorId = $fornecedorId;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    // CREATE
    public function salvar(): bool
    {
        $pdo = Database::getConexao();
        $stmt = $pdo->prepare(
            'INSERT INTO produtos (nome, descricao, preco, fornecedor_id) VALUES (:nome, :descricao, :preco, :fornecedor_id)'
        );
        return $stmt->execute([
            ':nome' => $this->nome,
            ':descricao' => $this->descricao,
            ':preco' => $this->preco,
            ':fornecedor_id' => $this->fornecedorId,
        ]);
    }

    // READ (lista com nome do fornecedor via JOIN)
    public static function listarTodos(): array
    {
        $pdo = Database::getConexao();
        $sql = 'SELECT p.*, f.nome AS fornecedor_nome 
                FROM produtos p 
                INNER JOIN fornecedores f ON f.id = p.fornecedor_id 
                ORDER BY p.nome ASC';
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    public static function buscarPorId(int $id): ?array
    {
        $pdo = Database::getConexao();
        $stmt = $pdo->prepare('SELECT * FROM produtos WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $resultado = $stmt->fetch();
        return $resultado ?: null;
    }

    public static function buscarPorIds(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }
        $pdo = Database::getConexao();
        $marcadores = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id IN ($marcadores)");
        $stmt->execute($ids);
        return $stmt->fetchAll();
    }

    // UPDATE
    public static function atualizar(int $id, string $nome, string $descricao, float $preco, int $fornecedorId): bool
    {
        $pdo = Database::getConexao();
        $stmt = $pdo->prepare(
            'UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco, fornecedor_id = :fornecedor_id WHERE id = :id'
        );
        return $stmt->execute([
            ':nome' => $nome,
            ':descricao' => $descricao,
            ':preco' => $preco,
            ':fornecedor_id' => $fornecedorId,
            ':id' => $id,
        ]);
    }

    // DELETE
    public static function excluir($id) {
    $db = Database::getConexao();

    // 1. Limpa as referências do produto na cesta antes de apagá-lo
    $stmtCesta = $db->prepare("DELETE FROM cesta_itens WHERE produto_id = :id");
    $stmtCesta->execute([':id' => $id]);

    // 2. Remove o produto da tabela principal
    $stmt = $db->prepare("DELETE FROM produtos WHERE id = :id");
    return $stmt->execute([':id' => $id]);
}
}