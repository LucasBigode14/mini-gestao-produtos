<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/Produto.php';

class Cesta
{
    public static function obterOuCriarCestaAberta(int $usuarioId): int
    {
        $pdo = Database::getConexao();
        $stmt = $pdo->prepare("SELECT id FROM cestas WHERE usuario_id = :usuario_id AND status = 'aberta' LIMIT 1");
        $stmt->execute([':usuario_id' => $usuarioId]);
        $cesta = $stmt->fetch();

        if ($cesta) {
            return (int) $cesta['id'];
        }

        $stmt = $pdo->prepare('INSERT INTO cestas (usuario_id) VALUES (:usuario_id)');
        $stmt->execute([':usuario_id' => $usuarioId]);
        return (int) $pdo->lastInsertId();
    }

    public static function adicionarProdutos(int $usuarioId, array $produtoIds): int
    {
        if (empty($produtoIds)) {
            throw new Exception('Selecione ao menos um produto.');
        }

        $cestaId = self::obterOuCriarCestaAberta($usuarioId);
        $pdo = Database::getConexao();
        $stmt = $pdo->prepare('INSERT IGNORE INTO cesta_itens (cesta_id, produto_id) VALUES (:cesta_id, :produto_id)');

        $adicionados = 0;
        foreach ($produtoIds as $produtoId) {
            $stmt->execute([
                ':cesta_id' => $cestaId,
                ':produto_id' => (int) $produtoId,
            ]);
            $adicionados += $stmt->rowCount();
        }

        return $adicionados;
    }

    public static function removerProduto(int $usuarioId, int $produtoId): bool
    {
        $cestaId = self::obterOuCriarCestaAberta($usuarioId);
        $pdo = Database::getConexao();
        $stmt = $pdo->prepare('DELETE FROM cesta_itens WHERE cesta_id = :cesta_id AND produto_id = :produto_id');
        return $stmt->execute([
            ':cesta_id' => $cestaId,
            ':produto_id' => $produtoId,
        ]);
    }

    public static function resumo(int $usuarioId): array
    {
        $cestaId = self::obterOuCriarCestaAberta($usuarioId);
        $pdo = Database::getConexao();
        $sql = 'SELECT p.id, p.nome, p.descricao, p.preco 
                FROM cesta_itens ci 
                INNER JOIN produtos p ON p.id = ci.produto_id 
                WHERE ci.cesta_id = :cesta_id 
                ORDER BY p.nome ASC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':cesta_id' => $cestaId]);
        $produtos = $stmt->fetchAll();

        $total = 0.0;
        foreach ($produtos as $produto) {
            $total += (float) $produto['preco'];
        }

        return [
            'cesta_id' => $cestaId,
            'produtos' => $produtos,
            'quantidade_itens' => count($produtos),
            'valor_total' => $total,
        ];
    }
}