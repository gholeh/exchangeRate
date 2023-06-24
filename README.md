## The steps for my Work:


1- Create laravel project ```composer create-project laravel/laravel:^9.0 exchangeRate```.

2- Setup redis configuration inside database.php to change redis client value ```'client' => env('REDIS_CLIENT', 'predis')```.

3- set three values in .env related to redis like that 
```   
    REDIS_HOST=localhost
    CACHE_DRIVER=redis
    SESSION_DRIVER=redis
```    
    
4- Install predis package ```composer require predis/predis```.

5- Create two migrations file one for currencies table and the second for currency_rates table:
   ```
   php artisan make:migration create_currencies_table --create=currencies
   php artisan make:migration create_currency_rates_table --create=currency_rates
   ```
6- Create three Models and add the relations inside Currency and CurrencyRate Models:
  ```
    php artisan make:Model DefaultModel
    php artisan make:Model Currency
    php artisan make:Model CurrencyRate
  ```
7- Create service inside services directory class to handle all the Functions.
8- Create Seeder to fetch the currencies from the thirdparty and fill the currencies table:
  ```
  php artisan make:seeder CurrencySeeder
  ```
9- Call the above seeder inside databaseSeeder.
10- Run the Seeder command:
  ```
    php artisan db:seed
  ```
11-Create Console command for CurrencyExchangeRates and register the command inside the app/Console/Kernel.php :
```
php artisan make:command CurrencyExchangeRates
```
12- Create Controller for the Endpoint ExchangeRateController with logic related to it:
```
php artisan make:controller Api/ExchangeRateController
```
13- Create Custom Request for the Endpoint to write the logic for the vaildtion:
```
php artisan make:request Api/ExchangeRateRequest
```
14- add the route for the endpoint inside the api.php:
```
Route::get('exchange-rate',[ExchangeRateController::class,'index']);
```
15- Create Unit test to test the console command and the endpoint:
```
php artisan make:test CurrencyExchangeRatesTest --unit
```
16- To run the test:
```
php artisan test --filter CurrencyExchangeRatesTest
```
17- The postman collection in the root directory to test the endpoint.

18- I made integration with https://www.frankfurter.app to handle the functions.


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
