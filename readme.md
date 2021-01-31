<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Ecomm Machine Test

To run application user below instruction.
 - Rename .env.example file to .env file
 - Create Database - ecomm
 - Run command - php artisan migrate
 - Run command - php artisan db:seed --class=UsersTableSeeder
 - Run command - php artisan db:seed --class=ProductTableSeeder
 - Run command - php artisan storage:link
 - Run command - php artisan serve

## Credentials

User Credentail 
- Active Status - 
username - john@gmail.com
password - user@123

username - rahul@gmail.com
password - user@123

## Points Covered
Below points are covered in this application

- Create table products and add the columns - id, product_name, product_price, product_desccription, product_image(save multiple images).
- Create add/edit/list/delete product form with the above-mentioned field and image upload should be multiple. (do not refresh the page)
- Use Jquery, ajax for all operations you perform for listing, use data tables or bootstrap datatable, or something like that.
- Use LAravel, Jquery, ajax, and Bootstrap

## License

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
