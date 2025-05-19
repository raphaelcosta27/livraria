# Livraria — Projeto Técnico TJ-JUD 📚✨

[Repositório no GitHub](https://github.com/raphaelcosta27/livraria.git)

## Requisitos Mínimos

* **PHP:** 8.2 ou superior
* **MySQL:** 8.0 ou superior
* **Composer:** Gerenciador de dependências PHP ([veja como instalar](https://getcomposer.org/))
* **NPM:** Gerenciador de pacotes do Node.js ([veja como instalar](https://nodejs.org/en/download))

> O Composer é utilizado para instalar e gerenciar dependências do backend (Laravel). O NPM é utilizado para instalar e compilar dependências de frontend (como Tailwind CSS, Livewire, etc).

Se você não possui um ambiente configurado, poderá utilizar um ambiente Docker completo através deste repositório: [ambiente-docker](https://github.com/raphaelcosta27/ambiente-docker.git) 🚢.

---

## Índice

* [Sobre o Projeto](#sobre-o-projeto)
* [Tecnologias Utilizadas](#tecnologias-utilizadas)
* [Como Executar](#como-executar)
* [Relatórios](#relatórios)
* [Testes (TDD)](#testes-tdd)
* [Boas Práticas e Diferenciais](#boas-praticas-e-diferenciais)
* [Instalação e Scripts](#instalacao-e-scripts)
* [Considerações Finais](#consideracoes-finais)

---

## Sobre o Projeto 🚀

Este projeto foi desenvolvido como parte do teste técnico do TJ-JUD, com o objetivo de demonstrar boas práticas em desenvolvimento Web, organização de código, persistência de dados e criação de relatórios.

O sistema é um cadastro de livros, permitindo o gerenciamento de livros, autores e assuntos, além da geração de relatórios agrupados por autor.

---

## Tecnologias Utilizadas 🛠️

* **Backend:** PHP (Laravel)
* **Frontend:** Blade (Laravel), Tailwind CSS
* **Banco de Dados:** MySQL (pode ser adaptado)
* **ORM/Persistência:** Eloquent (Laravel)
* **Relatórios:** \[Informe qual componente foi utilizado, ex: Laravel Excel, DomPDF, etc.]
* **Testes:** PHPUnit, Laravel Test (TDD — se implementado)
* **Outros:** PowerGrid, Livewire (opcional)

---

## Como Executar 🏁

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

   Após copiar, \*\*edite o arquivo \*\*\`\` e ajuste todas as propriedades necessárias, principalmente:

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

   Após rodar as migrations, você pode popular o banco de dados com alguns registros fictícios para testes utilizando o comando acima (`php artisan db:seed`).

   Esse comando irá criar automaticamente um usuário de teste:

   * **E-mail:** [admin@admin.com.br](mailto:admin@admin.com.br)
   * **Senha:** teste\@123

   Utilize essas credenciais para acessar o sistema e explorar as funcionalidades.

6. (Opcional) Execute os testes:

   ```bash
   php artisan test
   ```

7. Inicie o servidor:

   ```bash
   php artisan serve
   ```

---

## Relatórios 📊

Os relatórios do sistema são gerados utilizando o **PowerGrid** com exportação direta para Excel.

Os relatórios agrupam os livros por autor, mostrando as principais informações de livros e assuntos relacionados.

A consulta dos relatórios é baseada em uma **view do banco de dados**, conforme solicitado no desafio.

---

## Boas Práticas e Diferenciais 💡

* Código limpo, com separação clara de camadas
* Mensagens amigáveis para o usuário
* Uso de Tailwind CSS para padronização visual
* Utilização de view para relatórios
* Testes automatizados (TDD)
* Scripts de implantação/documentação incluídos

---

## Considerações Finais 🤝

O projeto será apresentado na entrevista técnica, com demonstração funcional das features e detalhamento técnico.

---
