# Laravel CRUD API
If get any error like while installing
```
SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long...
``` 
then goto '/app/Providers/AppServiceProvider.php' file and update boot method with 
```
Schema::defaultStringLength(191);
// more details in 
// https://stackoverflow.com/questions/42244541/laravel-migration-error-syntax-error-or-access-violation-1071-specified-key-wa
```

## Getting Started
To install project composer should be installed in your system (assuming using windows). Then

```
git clone git@github.com:rejoan/LaraWebDev2507.git && cd LaraWebDev2507
php artisan install:api
php artisan migrate

//for some demo data
php artisan db:seed
```

### Example Usage
First run the app through CLI

```
php artisan serve
```
Then send *POST* request to

```
http://127.0.0.1:8000/api/auth/login

parameters
-------------
email:rejoanul.alam@gmail.com, password:123456

response data
---------------
{
    "error": false,
    "message": "Login sucessfully",
    "errorCode": 4,
    "data": {
        "user_email": "rejoanul.alam@gmail.com",
        "token": "HGGa5UMlBftrNjMkPgWBx8LjY2L4uj7vGmTiqVPhecd0df0f"
    }
}
```