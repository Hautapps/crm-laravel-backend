Stack: PHP 8.4.11 / Laravel Framework 12.24.0, Postgres 17.6

# Getting Started

## 1. Docker

Install Docker

## 2. Environment

Copy .env.example to .env file

## 3. Start containers

Using Sail here but basically the same as docker compose

`./vendor/bin/sail up -d`

## 4. Run migrations and seed tables

`./vendor/bin/sail php artisan migrate --seed`

## 5. Create Api Key for Admin user

`./vendor/bin/sail php artisan tokens:generate admin@example.com`

---

# Tables
- customers: Customers for testing api
- users: Api users here
- api_tokens: Access tokens for Api Users
- ... Laravel related tables

---

# Routes

## Search Customers

**GET /api/customers**

- q: (String) = Full text search
- email: (String)
- createdAtMin: (Date)
- createdAtMax: (Date)
- limit: (Int) = default 10
- page: (Int) = default 1
- order: (String) = "asc"|"desc"
- sortBy: (String) = "name"|"email"|"createdAt" 

## Get single Customer

**GET /api/customers/{id}**

## Create new Customer

**POST /api/customers**

- name: String
- email: String

## Update Customer

**PUT /api/customers/{id}**

- name: String

## Delete Customer

***Note: Soft delete***

**DELETE /api/customers/{id}**
