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
 
![database](https://user-images.githubusercontent.com/38114768/80372466-c72c7f00-88bd-11ea-98b9-563d30d09b80.png)
 * `modify Mail`
 
![mail](https://user-images.githubusercontent.com/38114768/80372494-cdbaf680-88bd-11ea-8e0b-57bc2fe0192f.png)
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
### Homepage user
![dasbhoard_user_2](https://user-images.githubusercontent.com/38114768/80372237-69983280-88bd-11ea-8b4b-c8fab60131c0.png)
### Login User
![login_user](https://user-images.githubusercontent.com/38114768/80372375-a5cb9300-88bd-11ea-8fce-2452b4c77d47.png)
### Register User
![register](https://user-images.githubusercontent.com/38114768/80372408-ad8b3780-88bd-11ea-8e25-518ddd5a8f5d.png)
### Account Setting user
![account_setting_user](https://user-images.githubusercontent.com/38114768/80372425-b5e37280-88bd-11ea-91f3-012f98e47843.png)
### Dashboard Admin
![dashboard_admin](https://user-images.githubusercontent.com/38114768/80372449-bed44400-88bd-11ea-8ead-e3d48462ec97.png)

# Author

[Wahyu Aji Sulaiman](https://github.com/claytten/system_login_multi_guards)
