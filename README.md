## About Laravel

It is a backend app for Teebay. I used Laravel as a backend framework, PostgreSQL as a Database, Fortify for email verification, Sanctum for Api Authentication, Predis as Redis Driver.

### Installation Processes

- Rn git clone this repository
- Run composer install
- Run cp .env.example .env
- Run php artisan key:generate
- Run php artisan migrate
- Run php artisan db:seed --class=CategorySeeder
- Run php artisan serve
