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
laravel new LaraWebDev2507
php artisan install:api
php artisan migrate
```