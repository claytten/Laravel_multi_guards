# Template System Login Multi Guards
# Framework Laravel

## Requirement
 * `PHP 7.2>`
 * `NGINX/Apache (if you run on localhost, just use php artisan serve on console)`
 * `Mysql`
 * `composer`
 * `Ctype PHP Extension`
 * `Tokenizer PHP Extension`
 
## Extra Package
 * [jsdecena/baserepo](https://github.com/jsdecena/baserepo) `V1.0`
 * [spatie/laravel-permission](https://github.com/spatie/laravel-permission) `V3.0`

## Setup
 * `duplicate .env-example and rename to .env`
 * `Insert Identity Database`
 * `modify Mail`
 ```bash
 $ composer install
 ```
 ```bash
 $ php artisan key:generate
 ```
 ```bash
 $ php artisan migrate --seed
 ```
 ```bash
 $ php artisan storage:link
 ```


## Features
 * `Multi Guard Login`
 * `CRUD user/admin`
 * `Uploading avatar user/admin`
 * `Encryption link setting on front page`
 * `Verification Email`

## Next Features
 * `Sign Up with Social Media`
 * `Controlling User on Admin Panel`
 * `Customizing Verify Email`

## Notes
 * `This is my custom template login,register,role with spatie permission`

## Email and Passwords Admin
 * `superadmin@admin.com / Superadmin_1 (role:superadmin)`
 * `admin@admin.com / Admin_1 (role:admin)`
 * `clerk@admin.com / Clerk_1 (role:clerk)`
 
## Username/Email and password User
 * `(user1/user1@gmail.com) / User_111`
 * `(user2/user2@gmail.com) / User_222`
 * `(user3/user3@gmail.com) / User_333`

## Link Login
 * `admin / 127.0.0.1:8000/admin`
 * `user / 127.0.0.1:8000/login`

## Screenshoot

# Author

[Wahyu Aji Sulaiman](https://github.com/claytten/system_login_multi_guards)
