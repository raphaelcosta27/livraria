# Laravel Skeleton Template

<p align="center">
    <a href="https://laravel.com" target="_blank">
        <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
    </a>
</p>

<h1 align="center">Laravel Skeleton Template</h1>
<p align="center">
    Projeto base pronto para novos sistemas com autenticação, validação de e-mail, integração Mailtrap, Livewire, PowerGrid e Breadcrumbs.<br>
    Ideal para começar rápido, estudar ou usar em processos seletivos.<br>
</p>

---

## Recursos principais

* Laravel + Breeze (Blade + Tailwind CSS)
* Autenticação de usuários pronta
* Validação de e-mail integrada (usuários precisam confirmar o e-mail antes de acessar áreas restritas)
* Configuração pronta para envio de e-mails via Mailtrap
* Livewire instalado (para componentes dinâmicos)
* PowerGrid instalado (para tabelas avançadas e filtráveis)
* Breadcrumbs instalado (para navegação hierárquica)
* Pronto para testes automatizados com PHPUnit
* Exemplos de configuração de qualidade de código (PHPStan, PHPCS)
* Estrutura para CI/CD (GitHub Actions)

---

## ⚡️ Como rodar o projeto

### 1. Clone o repositório

```bash
git clone https://github.com/seu-usuario/laravel-skeleton.git
cd laravel-skeleton
```

### 2. Instale as dependências

```bash
composer install
npm install
```

### 3. Copie o arquivo de ambiente

```bash
cp .env.example .env
```

### 4. Gere a chave da aplicação

```bash
php artisan key:generate
```

### 5. Configure o banco de dados

No arquivo `.env`, configure suas variáveis:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_skeleton
DB_USERNAME=root
DB_PASSWORD=
```

> Crie o banco de dados caso ainda não exista.

### 6. Configure o Mailtrap para envio de e-mails

Preencha estas variáveis no `.env` com **seus dados do Mailtrap**:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=seu_usuario_mailtrap
MAIL_PASSWORD=sua_senha_mailtrap
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=seu@email.com
MAIL_FROM_NAME="Laravel Skeleton"
```

> Se ainda não tem conta, acesse: [https://mailtrap.io/](https://mailtrap.io/)

### 7. Rode as migrations

```bash
php artisan migrate
```

### 8. Compile os assets front-end

```bash
npm run dev
```

> Para ambiente de produção, use: `npm run build`

### 9. Rode o servidor de desenvolvimento

```bash
php artisan serve
```

> Acesse em [http://localhost:8000](http://localhost:8000)

---

## 🔌 Componentes Livewire e PowerGrid

Este template já está pronto para uso com Livewire e PowerGrid.

* **Livewire**: Crie componentes dinâmicos sem sair do Blade.
* **PowerGrid**: Crie tabelas dinâmicas, filtráveis e exportáveis com poucos comandos.

### Criando um componente Livewire

```bash
php artisan make:livewire NomeDoComponente
```

### Criando uma tabela PowerGrid para um Model

```bash
php artisan powergrid:create
```

> Veja a [documentação do PowerGrid](https://livewire-powergrid.com/) para exemplos de uso e personalização de tabelas.

---

## 🧭 Breadcrumbs (Navegação)

* O pacote [DaveJamesMiller/Laravel Breadcrumbs](https://github.com/davejamesmiller/laravel-breadcrumbs) já está instalado.
* Crie seus breadcrumbs em `routes/breadcrumbs.php`, seguindo o exemplo:

```php
<?php

use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;

Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Painel', route('dashboard'));
});
```

* Para exibir, coloque em sua view/layout:

```blade
@if (Breadcrumbs::has())
    <nav class="text-sm text-gray-500 py-2">
        {{ Breadcrumbs::render() }}
    </nav>
@endif
```

* Personalize os nomes e a hierarquia conforme suas rotas e módulos.

---

## 📨 Confirmação de e-mail

* Ao registrar um novo usuário, um e-mail de confirmação será enviado.
* O usuário precisa clicar no link enviado para validar a conta antes de acessar áreas protegidas (ex: dashboard).
* O sistema usa Mailtrap para simular o envio de e-mails em ambiente de desenvolvimento.

---

## 🧪 Rodando testes

```bash
php artisan test
# ou
vendor/bin/phpunit
```

---

## 🛠️ Ferramentas de qualidade (opcionais)

* PHPStan (`composer require --dev phpstan/phpstan`)
* PHP\_CodeSniffer (`composer require --dev squizlabs/php_codesniffer`)
* Exemplos de configuração em `phpstan.neon` e `phpcs.xml`.

---

## ⚙️ Dicas e observações

* Configure `Schema::defaultStringLength(191);` no método `boot()` do arquivo `app/Providers/AppServiceProvider.php` para evitar erros em bancos MySQL antigos.
* Nunca edite arquivos em `vendor/`.
* Tradução para português já inclusa via [laravel-lang/lang](https://github.com/Laravel-Lang/lang).
* Para gerar novas features, siga a estrutura dos controllers, models e rotas já presentes.

---

## 📚 Documentação

* [Documentação oficial do Laravel](https://laravel.com/docs)
* [Documentação do Breeze](https://laravel.com/docs/starter-kits#laravel-breeze)
* [Mailtrap](https://mailtrap.io/)
* [Livewire](https://laravel-livewire.com/docs/2.x/quickstart)
* [PowerGrid](https://livewire-powergrid.com/)
* [Laravel Breadcrumbs](https://github.com/davejamesmiller/laravel-breadcrumbs)

---

## 📝 Licença

Este projeto utiliza a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais informações.

---
