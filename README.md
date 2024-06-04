# Laravel Bank

O projeto em questão é uma versão simplificada das transações de um banco digital.

## Sumário

1. [Requisitos](#requisitos)
2. [Tecnologias Utilizadas](#tecnologias-utilizadas)
3. [Arquitetura](#arquitetura)
4. [Como Executar](#como-executar)
5. [Documentação API](#documentação-api)
6. [Testes](#testes)


## Requisitos

Eu como fundador do banco, gostaria de ter um sistema que me permita realizar transações financeiras entre contas de clientes.
Esta transação deve ter os seguintes requisitos:
- Deve ter dois tipos de perfil: Cliente e Lojista.
- O Logista deve somente receber transações.
- O Cliente pode pagar e receber transações.
- O saldo do cliente não pode ser menor que o valor da transação.

E como requisitos não funcionais:
- O sistema pode ser desenvolvido em linguagem ou framework de sua escolha.
- O sistema deve ser executado em container Docker.
- O sistema deve ter uma documentação de como executar o projeto.

## Tecnologias Utilizadas

- Laravel 11
- MySQL
- Redis
- PHP 8.3
- Nginx
- Docker

## Arquitetura

 - A arquitetura do projeto foi desenvolvida com base no padrão Service Repository, onde cada camada tem sua responsabilidade bem definida.
 - Diagrama de classes:
![classe_transacao_light](https://github.com/alissongla/transactions-api/assets/39539326/0aa7419b-e3a4-4cef-acab-10b9069dd2a2)
 - Fluxograma: 
![fluxograma_transacao_light](https://github.com/alissongla/transactions-api/assets/39539326/96971c4a-9be9-42c5-8fda-32b5320f157d)



## Como Executar

- Clone o repositório

```
git clone https://github.com/alissongla/transactions-api.git
```
- Entre na pasta do projeto e copie o arquivo .env.example para .env
```
cd transactions-api && cp .env.example .env
```

- Atualize as variáveis de ambiente no arquivo .env

``` 
APP_NAME=Laravel Bank
http://localhost:8890

APP_LOCALE=pt_BR
APP_FALLBACK_LOCALE=pt_BR
APP_FAKER_LOCALE=pt_BR

DB_CONNECTION=mysql
DB_HOST=db #nome do container do banco de dados
DB_PORT=3306
DB_DATABASE=laravel_bank
DB_USERNAME=root
DB_PASSWORD=root

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis

REDIS_CLIENT=phpredis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp #nome do container do servidor de email
MAIL_PORT=1025
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

UTIL_TOOLS_API_URL="https://util.devi.tools/api/"
```

- Suba os containers do projeto

```
docker-compose up -d
```

- Acessar o container

```
docker-compose exec app bash
```

- Instalar as dependências do projeto

```
composer install
```

- Gerar a key do projeto Laravel

```
php artisan key:generate
```

- Criar tabelas no banco de dados e popular com dados fake

```
php artisan migrate && php artisan db:seed
```

- Acessar o projeto http://localhost:8890

## Documentação API

### Requisições

| Rota                    | Método |Descrição
|-------------------------|--------|---
| `/api/transaction`      | POST   | Cria uma nova transação
| `/api/transaction/{id}` | DELETE | Deleta uma transação
| `/api/transaction/restore/{id}`                 | POST   | Restaura uma transação deletada

### Respostas

| Código | Descrição
|---|---
| `200` | Requisição executada com sucesso (success).
| `400` | Erros de validação ou os campos informados não existem no sistema.
| `404` | Registro pesquisado não encontrado (Not found).

## Testes
Para executar os testes do projeto, basta rodar o comando abaixo:

```
php artisan test
```
