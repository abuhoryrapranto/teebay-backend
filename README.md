## Teebay - Backend

It is a backend app. I used Laravel as a backend framework, PostgreSQL as a Database, Fortify for email verification, Sanctum for Api Authentication, Predis as Redis Driver.

### Installation Processes

- Rn git clone this repository
- cd [repository-name]
- Run composer install
- Run cp .env.example .env
- Run php artisan key:generate
- Run php artisan migrate
- Run php artisan db:seed --class=CategorySeeder
- Run php artisan serve
