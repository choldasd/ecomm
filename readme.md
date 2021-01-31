<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About User Managment

To run application user below instruction.
 - Rename .env.example file to .env file
 - Create Database - ums
 - Run command - php artisan migrate
 - Run command - php artisan db:seed --class=UsersTableSeeder
 - Run command - php artisan db:seed --class=AdminsTableSeeder
 - Run command - php artisan serve

## Credentials

User Credentail 
- Active Status - 
username - john@gmail.com
password - user@123

username - rahul@gmail.com
password - user@123

- Disable Status - 
username - amol@gmail.com
password - user@123

username - james@gmail.com
password - user@123

Admin credential 
- Admin - 
username - johnad@gmail.com
password - admin@123

## Points Covered
Below points are covered in this application

- Login
- Authentication of user
- CRUD on Users
- Middleware (to check user status)
CheckStatus middleware to check the status of users.

- Request Validation
StoreUser and UpdateUser Validation.

- For listing of users use DataTable js package in which you must load data using ajax.

## License

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
