# Wedevs Ecommerce backend 
# Laravel REST API with Sanctum and back end

## Usage

Change the *.env.example* to *.env* and add your database info

For MySQL, add
```
DB_DATABASE=your_DB_name
DB_USERNAME=root
DB_PASSWORD=
```

## Install the depencies with command
```
composer install
```

## Migration the database and dummy value
```
php artisan migrate --seed
```

## Run the webserver on port 8000
```
php artisan serve
```
# Follow the admin panel
```
http://127.0.0.1:8000/admin
email: hamza.iitju@gmail.com
password: hamza123
```
