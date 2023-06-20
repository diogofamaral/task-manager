
## Task Manager

### Using this project

To use this project you can clone this repo and start the application setup, make sure you have `PHP/composer` and `Docker` installed:
-  Save the file `.env.example` as `.env`
-  Run `composer install` To install dependencies
-  Bring the laravel sail containers up with `./vendor/bin/sail up -d`
-  Run `./vendor/bin/sail npm install` To use the npm from the default docker provided by Laravel Sail 
-  Run `./vendor/bin/sail artisan migrate --seed` To initialize the sqlite database (it should create database/database.sqlite file). This will generate two users (`john@email.com` and `jane@email.com`) with 50 mock tasks for each. The password is `password` for both.
-  Run `./vendor/bin/sail npm run build` To build and to watch for changes replace `build` with `dev`
-  Go to http://localhost:8080 and register an account, on the dashboard page you can work on the task
