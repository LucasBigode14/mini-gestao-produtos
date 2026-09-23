<?php
require_once __DIR__ . '/../config/database.php';

class Usuario
{
    private ?int $id = null;
    private string $nome;
    private string $email;

    public function __construct(string $nome = '', string $email = '')
    {
        $this->nome = $nome;
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

    public function getEmail(): string
    {
        return $this->email;
    }

    private static function gerarHash(string $senhaTexto): string
    {
        $salt = 'mini_gestao_produtos_salt';
        return hash('sha256', $salt . $senhaTexto);
    }

    public static function cadastrar(string $nome, string $email, string $senha): bool
    {
        $pdo = Database::getConexao();

        // Verifica se já existe um usuário com esse e-mail
        $stmt = $pdo->prepare('SELECT id FROM usuarios WHERE email = :email');
        $stmt->execute([':email' => $email]);

        if ($stmt->fetch()) {
            throw new Exception('Este e-mail já está cadastrado.');
        }

        $hash = self::gerarHash($senha);

        $stmt = $pdo->prepare(
            'INSERT INTO usuarios (nome, email, senha_hash) VALUES (:nome, :email, :senha_hash)'
        );

        return $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':senha_hash' => $hash,
        ]);
    }

    public static function autenticar(string $email, string $senha): ?array
    {
        $pdo = Database::getConexao();

        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE email = :email');
        $stmt->execute([':email' => $email]);

        $usuario = $stmt->fetch();

        if (!$usuario) {
            return null; // e-mail não encontrado
        }

        $hashDigitado = self::gerarHash($senha);

        if (!hash_equals($usuario['senha_hash'], $hashDigitado)) {
            return null; // senha errada
        }

        return $usuario;
    }
}