# Como executar o projeto

**Instalação das dependências. No terminal, digite:**

```php
composer install
```

**Caso esteja executando pela primeira vez**

```php
php artisan key:generate
```

**Esta aplicação utiliza a API Brapi para consultar preço das ações. A API é gratuita para fins educacionais, mas você precisa gerar um token no site: https://brapi.dev/ e utilizar este token no arquivo .env, na linha:**

```php
BRAPI_TOKEN="Seu_Token"
```

**Também no .env, você precisa configurar a conexão com o seu banco de dados MySQL. Basta substituir os dados pelos dados da sua conexão:**

```php
DB_DATABASE=database
DB_USERNAME=username
DB_PASSWORD= "password"
```

**Após isso, precisa executar as migrations para gerar as tabelas no banco de dados:**

```php
php artisan migrate
```

**Com tudo configurado, basta iniciar o servidor:**

```php
php artisan serve
```
