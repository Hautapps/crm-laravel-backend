Stack: PHP, Laravel, Postgres

## Docker

Install Docker

## Environment

Copy .env.example to .env file

## Start containers

Using Sail here but basically the same as docker compose

(sudo) ./vendor/bin/sail up -d

## Run migrations and seed tables

./vendor/bin/sail php artisan migrate --seed

## Create Api Key for Admin user

./vendor/bin/sail php artisan tokens:generate admin@example.com

## Tables
- customers: Customers for testing api
- users: Api users here
- api_tokens: Access tokens for Api Users
- ... Laravel related tables

## Routes

- Search Customers -

GET /api/customers

q: (String) = full text search
email: (String)
createdAtMin: (Date)
createdAtMax: (Date)
limit: (Int) = default 10
page: (Int) = default 1
order: (String) = "asc"|"desc"
sortBy: (String) = "name"|"email"|"createdAt" 

- Get single Customer -

GET /api/customers/{id}

- Create new Customer -

POST /api/customers

name: String
email: String

- Update Customer -

PUT /api/customers/{id}

name: String

- Delete Customer -

Note: Soft delete

DELETE /api/customers/{id}
