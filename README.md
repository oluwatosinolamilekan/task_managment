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

Now, the most important, build and start the package dependencies by running
`composer install`

Composer will start doing its magic. All required dependencies, will be installed.


```
 cp .env.example .env
```


While composer is doing its magic, you need to add to modify `.env` file:
```
 DB_CONNECTION=mysql
 DB_HOST=127.0.0.1
 DB_PORT=3306
 DB_DATABASE=laravel
 DB_USERNAME=root
 DB_PASSWORD=
```

### To Migrate the database in the project, command below
```
 php artisan migrate
```

- Make sure you having this to your .env file `PROCESS_TASK_URL="http://127.0.0.1:5000"` 

While migrating the database, you need to serve the project with this command `php artisan serve`


- After laravel project get running, move to the python project respository [click here](https://github.com/oluwatosinolamilekan/task_management_py) is running before performing any operation in the view/

## Features

- Lists, create, and update, tasks managements.

### How to run tests
```
 php artisan test
```