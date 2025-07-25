<img src="preview.png" width="100%">
<img width="100%" src="dashboard.png">

An implementation of a Customer Support Chat System in Laravel.

This project will continue to grow and will be maintained. Your support is highly appreciated and will motivate the author to improve the package. If you've found this library helpful and want to support the author, please, consider any donation by clicking the button below or following the link to [buymeacoffee.com](https://www.buymeacoffee.com/ilmedova). 

<a href="https://www.buymeacoffee.com/ilmedova" target="_blank"><img align="center" src="https://cdn.buymeacoffee.com/buttons/v2/default-yellow.png" alt="Buy Me A Coffee" height="55px" width= "200px"></a>

## Table of Contents
1. [Features](#features)
2. [Requirements](#requirements)
3. [Installation](#installation)
4. [What's next?](#todo)
4. [License](#license)

## <a name="features"></a> Features 🤩

- Customer support chatbox in every single page of your web app
- Admin panel for chatting with customers (available at: http://your-domain/chattle/chat-admin)
- Self-hosted pusher replacement by beyondcode laravel websockets

## <a name="requirements"></a> Requirements

- Laravel 10
- PHP 8.1 or higher

## <a name="installation"></a> Installation

Default installation is via [Composer](https://getcomposer.org/).

```bash
composer require ilmedova/chattle --with-all-dependencies
```

The service provider will automatically get registered. Or you could add the Service Provider manually to your
`config/app` file in the `providers` section.

```php
'providers' => [
    //...
    Ilmedova\Chattle\ChatServiceProvider::class,
]
```

Publish the assets for css and js files

```bash
php artisan vendor:publish --provider="Ilmedova\Chattle\ChatServiceProvider"
```


Configure the following in your .env

`BROADCAST_DRIVER=pusher`

`PUSHER_APP_ID=qwerty12345`

`PUSHER_APP_KEY=qwerty12345`

`PUSHER_APP_SECRET=qwerty12345`

`PUSHER_HOST=127.0.0.1`

`PUSHER_PORT=6001`

`PUSHER_SCHEME=http`

`PUSHER_APP_CLUSTER=mt1`

If you want to change the pusher app key and secret make sure that you change them not only in .env file, but also in /public/js/chattle_customer.js and /public/js/chattle_admin.js - where the pusher instance is created

Run the migrations in order to setup the required tables on the database.

```bash
php artisan migrate
```

Include the customer support chatbox on your layout blade file's body section

```php
@include('chattle::chat')
```

Now serve your websockets and laravel app in different command lines

```bash
php artisan websockets:serve
```

```bash
php artisan serve
```

Admin dashboard for chatting with customers available at http://your-domain/chattle/chat-admin 
 
## <a name="todo"></a> What's next 🚀

- Realtime typing effect in chatboxes for users to let know that user or admin is typing
- Marking messages as read when they are read by user or admin
- Middleware and chat-admin roles control
- Multiple color themes configured in configs

## <a name="license"></a> License

Laravel Customer Support Chat - is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
