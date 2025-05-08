# Laravel x Autz.org

This is just an example of Autz.org implementation with Laravel PHP Framework.

## How to run

Make sure you have mysql, php and composer installed on your machine.

Install dependencies with composer
```bash
composer install
```

Then, prepare the database by running the following commands.

```bash
# DB migration
php artisan migrate

# User seeder
php artisan db:seed
```

Run the server and open the http://localhost:8000 on the browser

```bash
# Run the server
php artisan serve
```

## Resources

- [Laravel 10 docs](https://laravel.com/docs/10.x)
- [Autz.org docs](https://about.autz.org/p/docs)

## Contributing

Please create an issue or pull request.
