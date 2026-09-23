<?php
require_once __DIR__ . '/../config/database.php';

class Fornecedor
{
    private ?int $id;
    private string $nome;
    private string $cnpj;
    private string $telefone;
    private string $email;

    public function __construct(
        string $nome = '',
        string $cnpj = '',
        string $telefone = '',
        string $email = '',
        ?int $id = null
    ) {
        $this->id = $id;
        $this->nome = $nome;
        $this->cnpj = $cnpj;
        $this->telefone = $telefone;
        $this->email = $email;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    // CREATE
    public function salvar(): bool
    {
        $pdo = Database::getConexao();
        $stmt = $pdo->prepare(
            'INSERT INTO fornecedores (nome, cnpj, telefone, email) VALUES (:nome, :cnpj, :telefone, :email)'
        );
        return $stmt->execute([
            ':nome' => $this->nome,
            ':cnpj' => $this->cnpj,
            ':telefone' => $this->telefone,
            ':email' => $this->email,
        ]);
    }

    // READ (lista todos)
    public static function listarTodos(): array
    {
        $pdo = Database::getConexao();
        $stmt = $pdo->query('SELECT * FROM fornecedores ORDER BY nome ASC');
        return $stmt->fetchAll();
    }

    // READ (busca um pelo id)
    public static function buscarPorId(int $id): ?array
    {
        $pdo = Database::getConexao();
        $stmt = $pdo->prepare('SELECT * FROM fornecedores WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $resultado = $stmt->fetch();
        return $resultado ?: null;
    }

    // UPDATE
    public static function atualizar(int $id, string $nome, string $cnpj, string $telefone, string $email): bool
    {
        $pdo = Database::getConexao();
        $stmt = $pdo->prepare(
            'UPDATE fornecedores SET nome = :nome, cnpj = :cnpj, telefone = :telefone, email = :email WHERE id = :id'
        );
        return $stmt->execute([
            ':nome' => $nome,
            ':cnpj' => $cnpj,
            ':telefone' => $telefone,
            ':email' => $email,
            ':id' => $id,
        ]);
    }

    // DELETE
    public static function excluir(int $id): bool
    {
        $pdo = Database::getConexao();
        $stmt = $pdo->prepare('DELETE FROM fornecedores WHERE id = :id');
        return $stmt->execute([':id' => $id]);
    }
}