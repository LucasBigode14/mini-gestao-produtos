# Mini Gestão de Produtos

Sistema simples de gestão de produtos, fornecedores e cesta de compras, desenvolvido em PHP com MySQL e interface em Bootstrap. O projeto foi criado para exercitar operações fundamentais de CRUD, autenticação de usuários e relacionamento entre entidades.

## Visão geral

A aplicação permite:

- cadastrar e autenticar usuários;
- gerenciar fornecedores;
- cadastrar, listar e excluir produtos;
- organizar itens em uma cesta de compras;
- visualizar um dashboard com resumo geral da aplicação;
- manter a estrutura de dados em banco MySQL com criação automática das tabelas.

## Funcionalidades principais

- Autenticação de usuários com sessão.
- Cadastro de conta e login.
- Gestão de fornecedores.
- Cadastro de produtos vinculados a um fornecedor.
- Cesta de compras por usuário.
- Resumo de itens e valor total da cesta.
- Dashboard com indicadores de quantidade de produtos, fornecedores e itens na cesta.

## Diagrama de entidade e relacionamento

![DER](./images/DER.png)

## Documentação complementar

- [Relatório completo](./files/Relatorio_Mini_Gestao_Produtos.pdf)

## Tecnologias utilizadas

- PHP 8+
- MySQL / MariaDB
- PDO para acesso ao banco
- Bootstrap 5 para layout
- JavaScript para interações em páginas dinâmicas

## Pré-requisitos

Antes de executar o projeto, verifique se os itens abaixo estão instalados e configurados:

- XAMPP, WAMP ou outro ambiente com Apache + MySQL
- PHP
- MySQL/MariaDB
- Navegador web moderno

## Configuração e execução

1. Clone o repositório para a pasta do seu servidor web, por exemplo `htdocs` do XAMPP:

   ```bash
   git clone https://github.com/lucas140198-art/mini-gestao-produtos.git
   ```

2. Inicie o Apache e o MySQL no seu ambiente local.

3. Acesse a aplicação no navegador:

   ```text
   http://localhost/mini-gestao-produtos/
   ```

4. O sistema tenta criar automaticamente o banco de dados e as tabelas necessárias quando a aplicação é acessada pela primeira vez.

## Configuração do banco de dados

Os parâmetros de conexão do banco estão em:

- `config/database.php`

Valores padrão utilizados no projeto:

```php
private const HOST = '127.0.0.1';
private const PORT = '3306';
private const DB_NAME = 'mini_gestao_produtos';
private const USER = 'root';
private const PASS = '';
```

Se o seu ambiente utilizar outra porta, usuário ou senha do MySQL, ajuste esses valores antes de iniciar a aplicação.

## Estrutura do projeto

```text
mini-gestao-produtos/
├── ajax/                   # endpoints AJAX para fornecedores, produtos e cesta
├── assets/                 # arquivos estáticos (CSS/JS) e recursos front-end
├── auth/                   # telas de login e cadastro
├── classes/                # regras de negócio e acesso ao banco
├── config/                 # configuração do banco de dados
├── files/                  # relatórios e arquivos complementares
├── includes/               # cabeçalhos, navbar e controle de sessão
├── images/                 # imagens de documentação
├── index.php               # página de login
├── dashboard.php           # painel principal da aplicação
├── produtos.php            # gestão de produtos
├── fornecedores.php        # gestão de fornecedores
├── cesta.php               # visualização e operação da cesta
├── selecionar_produtos.php # seleção de produtos
├── README.MD               # documentação do projeto
└── ...
```

## Fluxo de uso

1. Acesse a página inicial e crie uma conta.
2. Faça login com seu e-mail e senha.
3. Cadastre fornecedores e produtos.
4. Adicione produtos à cesta de compras.
5. Consulte o dashboard e a cesta para acompanhar o resumo.

## Estado do projeto

Este repositório está em desenvolvimento local e foi estruturado como uma aplicação prática de estudo e demonstração de CRUD em PHP.

## Observações importantes

- O ambiente depende de um servidor MySQL acessível localmente.
- A criação automática de banco e tabelas é feita na classe de conexão do projeto.
- Não há uma suíte de testes automatizados configurada neste repositório no momento.

## Contribuição

Contribuições são bem-vindas. Para propor melhorias:

1. faça um fork do projeto;
2. crie uma branch com sua alteração;
3. envie um pull request descrevendo claramente a mudança;
4. mantenha o código consistente com o padrão já adotado no repositório.

## Licença

Este projeto não possui uma licença formal definida no repositório no momento.
