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
composer install
```

### Rename *.env.example* to *.env* and create a DB "larawebdev2507" and then

```
php artisan migrate
php artisan install:api
//DB Seeder for some demo data (user & category)
php artisan db:seed

composer require nesbot/carbon
```

### Example Usage
First run the app through CLI (goto project root directory through *cd*)

```
php artisan serve
```
Then send *POST* request to

```
http://127.0.0.1:8000/api/auth/login
```

parameters
-------------
```
email:rejoanul.alam@gmail.com
password:123456
```

response data
---------------

```
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

Now using above returned token you may use other endpoints. For example *GET* request to following endpoint will return article list created by loggedin user

```
http://127.0.0.1:8000/api/articles/mine
```
response data
--------------

```
{
    "data": [
        {
            "id": 1,
            "title": "article 1 updated",
            "slug": "article_1_updated",
            "body": "body updated1",
            "status": "draft",
            "category_id": 1,
            "created_by": 1,
            "created_at": "2025-07-17T17:12:26.000000Z",
            "updated_at": "2025-07-17T18:02:27.000000Z"
        },
....
```

## Set API rate limit

*POST* request to following endpoint

```
http://127.0.0.1:8000/api/set/limit/minute
```

parameters
------------
per_min:3 (Default 5)

## Daily API RATE limit & category CRUD not created because same things created in Article CRUD & minute limit