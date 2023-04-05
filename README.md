==================================================== 
project installation guidelines
====================================================

1. Download project from https://github.com/nishan002/mini_sales

2. From project folder run `composer install`

3. For package install. run following command
    - `composer require yajra/laravel-datatables:"^9.0"`
    - `composer require barryvdh/laravel-dompdf`

4. From the project folder copy '.env.example' and create new '.env' file

5. run command - `php artisan key:generate`

6. Edit '.env' file and change to DB_DATABASE=mini_sales

7. Migrate all DB table - `php artisan migrate`

8. Populate DB with some demo data - `php artisan db:seed`

9. To run the project - `php artisan serve`

The login page will show up. you can redirect to login page from there and register as a user.
