## RESTful API

It is a RESTful API written in PHP(Laravel) using Laravel Passport. To be able to interact using postman or external system.

```bash
Auth section can:
register
login
logout
```

```bash
Expense section can:
index
store
show
update
destroy
```

## Stack
Laravel v7.25.0

Passport v9.3

## Links
[Database dbdiagram.io](https://dbdiagram.io/d/5f4112fe7b2e2f40e9de62f7)

[Project GitHub Page](https://github.com/marcovie/realtimeTodoList)

[http://127.0.0.1:8000/api/documentation](http://127.0.0.1:8000/api/documentation)

## Installation

```bash
Step 1 - git clone https://github.com/marcovie/realtimeTodoList
Step 2 - composer install
Step 3 - Make copy of the .env.example file and change the copy name to .env,
open file and change settings required.

Step 4 - Make database same name as you stated in .env file.
Step 5 - php artisan key:generate
Step 6 - php artisan migrate --seed
Step 7 - php artisan passport:install
Step 8 - php artisan serve
```

## Usage

```php
//Read documentations
Go to command line to the root of project and run: php artisan serve
Then visit: http://{url}/api/documentation
//Unit test
Go to command line to the root of project and run: php artisan test
```


## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
