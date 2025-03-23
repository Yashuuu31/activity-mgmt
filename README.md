# Project Setup Guide

Follow the steps below to set up the project:

## 1. Install Dependencies
Run the following command to install the required dependencies using Composer:
```sh
composer install
```

## 2. Create Environment File
Copy the example environment file and configure it as needed:
```sh
cp .env.example .env
```
Then generate the application key:
```sh
php artisan key:generate
```

## 3. Run Migrations
Execute the following command to create the database tables:
```sh
php artisan migrate
```

## 4. Seed the Database
Run the seeder command to populate the database with initial data:
```sh
php artisan db:seed
```

## 5. Run Queue Worker
Start the queue worker to process queued jobs:
```sh
php artisan queue:work
```

## 6. Start the Development Server
Run the following command to start the Laravel development server:
```sh
php artisan serve
```

---

Now your project is set up and ready to run! 🚀

