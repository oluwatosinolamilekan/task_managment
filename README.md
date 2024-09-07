## Overview

A simple task management application in Laravel that communicates with a
Python service. The application will allow users to create tasks, mark them as completed, and
view task details. Once a task is created, a Python script should respond with a message to
simulate external processing.


## Minimum system requirements

- PHP >= 8.1
- Laravel 10
- Mysql


## How to run the application
Below are the steps you need to successfully setup and run the application.

- Clone the app from the repository and cd into the root directory of the app

- Run `composer install`
- Copy `.env.example into .env`
- Update DB credentials to match with your database
- Make sure you having this to your .env file `PROCESS_TASK_URL="http://127.0.0.1:5000"` 
- Run `php artisan migrate`
- To run quick database generation for menus run `php artisan db:seed` (TaskFactory already implemented in the databaseeder);
- Run `php artisan serve`
- After the laravel project get running make sure you run the python project also with `python app.py` in the python project project

## Features

- Lists, create, and update, tasks managements.
