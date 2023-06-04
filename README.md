Stack:
- PHP 8
- Laravel 8.83
- MongoDB 4.2

Setup:
1. Run `composer install`.
2. If you're using Linux or macOS, execute the command `mv .env.example .env`. If you're using Windows, use `ren .env.example .env`.
3. Generate an application key by running `php artisan key:generate`.
4. Apply the database migrations and seed the database by executing `php artisan migrate --seed`.
5. Set up the JWT secret by running `php artisan jwt:secret`.
6. Start the development server with `php artisan serve`.
7. Optionally, run tests with `php artisan test`. If you want to generate code coverage reports, use `php artisan test --coverage-html=coverage`.

Postman Headers:
- Accept: application/json
- Authorization: Bearer {{accessToken}}

Additional Folders:
- Coverage: Contains the latest test coverage data.
- Collections: Includes Postman collections for auth, kendaraan, users, and global environment variables (global env).
