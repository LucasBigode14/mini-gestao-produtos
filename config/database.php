<?php

class Database
{
    private const HOST = '127.0.0.1';
    private const PORT = '3306';
    private const DB_NAME = 'mini_gestao_produtos';
    private const USER = 'root';
    private const PASS = '';

    private static ?PDO $instancia = null;

    private function __construct()
    {
    }

    public static function getConexao(): PDO
    {
        if (self::$instancia === null) {
            self::criarBancoSeNaoExistir();

            $dsn = 'mysql:host=' . self::HOST . ';port=' . self::PORT .
                   ';dbname=' . self::DB_NAME . ';charset=utf8mb4';

            $opcoes = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            self::$instancia = new PDO($dsn, self::USER, self::PASS, $opcoes);
        }

        return self::$instancia;
    }

    private static function criarBancoSeNaoExistir(): void
    {
        $dsn = 'mysql:host=' . self::HOST . ';port=' . self::PORT . ';charset=utf8mb4';
        $pdoTemp = new PDO($dsn, self::USER, self::PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        $pdoTemp->exec(
            'CREATE DATABASE IF NOT EXISTS ' . self::DB_NAME .
            ' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci'
        );

        $pdoTemp->exec('USE ' . self::DB_NAME);

        // ---- Tabela de usuários ----
        $pdoTemp->exec("
            CREATE TABLE IF NOT EXISTS usuarios (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(120) NOT NULL,
                email VARCHAR(150) NOT NULL UNIQUE,
                senha_hash VARCHAR(255) NOT NULL,
                criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB
        ");

        // ---- Tabela de fornecedores ----
        $pdoTemp->exec("
            CREATE TABLE IF NOT EXISTS fornecedores (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(150) NOT NULL,
                cnpj VARCHAR(20) NOT NULL,
                telefone VARCHAR(20),
                email VARCHAR(150),
                criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB
        ");

        // ---- Tabela de produtos ----
        $pdoTemp->exec("
            CREATE TABLE IF NOT EXISTS produtos (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(150) NOT NULL,
                descricao VARCHAR(255),
                preco DECIMAL(10,2) NOT NULL,
                fornecedor_id INT NOT NULL,
                criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT fk_produto_fornecedor
                    FOREIGN KEY (fornecedor_id) REFERENCES fornecedores(id)
                    ON DELETE CASCADE
            ) ENGINE=InnoDB
        ");

        // ---- Tabela de cestas ----
        $pdoTemp->exec("
            CREATE TABLE IF NOT EXISTS cestas (
                id INT AUTO_INCREMENT PRIMARY KEY,
                usuario_id INT NOT NULL,
                status ENUM('aberta','finalizada') DEFAULT 'aberta',
                criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT fk_cesta_usuario
                    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
                    ON DELETE CASCADE
            ) ENGINE=InnoDB
        ");

        // ---- Tabela de itens da cesta ----
        $pdoTemp->exec("
            CREATE TABLE IF NOT EXISTS cesta_itens (
                id INT AUTO_INCREMENT PRIMARY KEY,
                cesta_id INT NOT NULL,
                produto_id INT NOT NULL,
                criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                CONSTRAINT fk_item_cesta
                    FOREIGN KEY (cesta_id) REFERENCES cestas(id)
                    ON DELETE CASCADE,
                CONSTRAINT fk_item_produto
                    FOREIGN KEY (produto_id) REFERENCES produtos(id)
                    ON DELETE CASCADE,
                UNIQUE KEY unico_produto_por_cesta (cesta_id, produto_id)
            ) ENGINE=InnoDB
        ");
    }
}