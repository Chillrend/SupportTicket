Run Locally :
1. copy `.env.example` and save as `.env` and then edit your database credential
2. run `composer install`
3. run `php artisan key:generate`
4. run `php artisan migrate`
5. run `php artisan serve` and access `http://localhost:8000`
6. register a user, if you want admin access, change the `is_admin` column at database to `1` manually
