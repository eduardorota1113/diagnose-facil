
# DiagnoseFácil

## Sobre o projeto

O DiagnoseFácil é uma aplicação acadêmica desenvolvida
em PHP para gerenciar usuários e registrar diagnósticos
de problemas residenciais.

Esta versão implementa o gerenciamento dos registros.
Não realiza diagnósticos automáticos por inteligência
artificial.

## Tecnologias utilizadas

- PHP 8.2
- Programação Orientada a Objetos
- Arquitetura MVC
- Padrão DAO
- PDO
- MySQL/MariaDB
- HTML e CSS
- XAMPP

## Funcionalidades

- Cadastrar usuários
- Consultar usuários
- Editar usuários
- Excluir usuários
- Cadastrar diagnósticos
- Consultar diagnósticos
- Editar diagnósticos
- Excluir diagnósticos
- Painel com quantidade de registros
- Navegação entre páginas
- Validação básica dos formulários
- Proteção CSRF nos formulários

## Estrutura do projeto

- app/Config: conexão com o banco
- app/Models: classes que representam os dados
- app/DAO: acesso ao banco e operações CRUD
- app/Controllers: regras e controle das operações
- app/Views: páginas da interface
- public: arquivo principal e estilos
- database: script de criação do banco

## Como executar

1. Instale o XAMPP com PHP e MySQL/MariaDB.
2. Coloque a pasta diagnose_facil_app dentro de htdocs.
3. Inicie Apache e MySQL no XAMPP.
4. Abra o phpMyAdmin.
5. Importe database/diagnose_facil.sql em uma
   instalação nova do banco.
6. Confira as configurações de app/Config/Conexao.php.
7. Acesse:

http://localhost/diagnose_facil_app/public/

## Banco de dados

O banco diagnose_facil possui duas tabelas relacionadas:

- usuario
- diagnostico

Um usuário pode possuir vários diagnósticos.

A ligação entre as tabelas utiliza uma chave estrangeira.

## Programação Orientada a Objetos

O projeto utiliza classes, objetos, construtores,
encapsulamento, tipagem, interfaces e polimorfismo.

A interface RepositorioInterface define um contrato
compartilhado pelos DAOs.

O PainelController utiliza esse contrato para consultar
diferentes tipos de registros.

## MVC e DAO

Model:
representa os dados do sistema.

View:
mostra os formulários e as informações na tela.

Controller:
recebe as operações e coordena as ações do sistema.

DAO:
executa os comandos SQL e acessa o banco de dados.

## Segurança e limitações

O projeto utiliza consultas preparadas com PDO,
tratamento de saída HTML e proteção CSRF.

Esta é uma aplicação acadêmica local, sem autenticação
de usuários, e não deve ser exposta publicamente
sem medidas adicionais de segurança.

## Uso de inteligência artificial

Ferramentas de inteligência artificial foram utilizadas
como apoio à elaboração e revisão de código, explicações
técnicas e organização do projeto.

O código deve ser revisado e testado pelos integrantes.

## Integrantes

- Nome: [PREENCHER]
- RA: [PREENCHER]

## Instituição

- Curso: Análise e Desenvolvimento de Sistemas
- Disciplina: [PREENCHER]
- Professor: [PREENCHER]
