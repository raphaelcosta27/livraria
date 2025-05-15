# Livraria — Projeto Técnico TJ-JUD

[Repositório no GitHub](https://github.com/raphaelcosta27/livraria.git)

## Índice

* [Sobre o Projeto](#sobre-o-projeto)
* [Tecnologias Utilizadas](#tecnologias-utilizadas)
* [Como Executar](#como-executar)
* [Funcionalidades](#funcionalidades)
* [Modelagem de Dados](#modelagem-de-dados)
* [Relatórios](#relatórios)
* [Testes (TDD)](#testes-tdd)
* [Boas Práticas e Diferenciais](#boas-práticas-e-diferenciais)
* [Instalação e Scripts](#instalação-e-scripts)
* [Considerações Finais](#considerações-finais)

---

## Sobre o Projeto

Este projeto foi desenvolvido como parte do teste técnico do TJ-JUD, com o objetivo de demonstrar boas práticas em desenvolvimento Web, organização de código, persistência de dados e criação de relatórios.

O sistema é um cadastro de livros, permitindo o gerenciamento de livros, autores e assuntos, além da geração de relatórios agrupados por autor.

---

## Tecnologias Utilizadas

* **Backend:** PHP (Laravel)
* **Frontend:** Blade (Laravel), Bootstrap (CSS)
* **Banco de Dados:** MySQL (pode ser adaptado)
* **ORM/Persistência:** Eloquent (Laravel)
* **Relatórios:** \[Informe qual componente foi utilizado, ex: Laravel Excel, DomPDF, etc.]
* **Testes:** PHPUnit, Laravel Test (TDD — se implementado)
* **Outros:** PowerGrid, Livewire (opcional)

---

## Como Executar

1. Clone este repositório:

   ```bash
   git clone https://github.com/raphaelcosta27/livraria.git
   cd livraria
   ```

2. Instale as dependências:

   ```bash
   composer install
   npm install && npm run dev
   ```

3. Copie o arquivo `.env.example` para `.env`:

   ```bash
   cp .env.example .env
   ```

   Após copiar, **edite o arquivo `.env`** e ajuste todas as propriedades necessárias, principalmente:

   * As configurações de acesso ao banco de dados (`DB_*`)

   * As informações de e-mail (`MAIL_*`).

   > **Atenção:** É fundamental configurar corretamente os dados de e-mail (MAIL\_MAILER, MAIL\_HOST, MAIL\_PORT, MAIL\_USERNAME, MAIL\_PASSWORD, etc). Sem isso, o usuário não conseguirá receber o e-mail de autenticação ao se registrar, e não poderá acessar o sistema após o cadastro.

4. Gere a chave da aplicação:

   ```bash
   php artisan key:generate
   ```

5. Execute as migrations e seeders:

   ```bash
   php artisan migrate --seed
   ```

6. (Opcional) Execute os testes:

   ```bash
   php artisan test
   ```

7. Inicie o servidor:

   ```bash
   php artisan serve
   ```

---

## Funcionalidades

* CRUD completo para **Livro**, **Autor** e **Assunto**
* Tela inicial com navegação simples
* Interface responsiva e estilizada com Bootstrap
* Formatação de campos (datas, moeda, etc)
* Validação e tratamento de erros específico (sem try/catch genérico)
* Relatório agrupado por autor, gerado a partir de view no banco de dados
* Testes automatizados (TDD, se implementado)

---

## Modelagem de Dados

O projeto segue o seguinte modelo de dados:

* **Livro** (id, título, data\_publicação, valor, etc)
* **Autor** (id, nome, etc)
* **Assunto** (id, descrição, etc)
* Relacionamento: Livro pode ter mais de um Autor (N\:N), e pertence a um Assunto

> Scripts de criação das tabelas, seeds e views estão disponíveis na pasta `/database`.

---

## Relatórios

O relatório do sistema exibe os livros cadastrados agrupados por autor, com as principais informações dos livros e assuntos relacionados.
A consulta do relatório é realizada a partir de uma **view no banco de dados**, conforme o desafio.

---

## Testes (TDD)

O projeto possui testes automatizados cobrindo os principais fluxos de cadastro, edição, exclusão e geração de relatórios (se implementado).

---

## Boas Práticas e Diferenciais

* Código limpo, com separação clara de camadas
* Mensagens amigáveis para o usuário
* Uso de Bootstrap para padronização visual
* Utilização de view para relatórios
* Testes automatizados (TDD)
* Scripts de implantação/documentação incluídos

---

## Instalação e Scripts

Todos os scripts de criação de tabelas, seeds, views e instruções de implantação estão disponíveis na pasta `/database` deste projeto.

---

## Considerações Finais

O projeto será apresentado na entrevista técnica, com demonstração funcional das features e detalhamento técnico.

---
