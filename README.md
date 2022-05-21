## System Requirement

- Laravel 9
- PHP 8.0.19 (PHP > 8)
- Composer version 2.2.9
- Redis & Horizon are required to run on the background
- For Windows OS, require container(such as Docker) to run Redis
- For Windows OS, Horizon cannot be serve. Thus Laravel Queue are required as an alternative

    $ php artisan queue:listen --timeout=900 --queue=default,horizon

## Installation

Clone the project in your workspace

    $ git clone git@gitlab.com:syahidnorazman/youprint-miniproject.git
    $ cd youprint-miniproject

Copy .env file

    $ copy .env.localhost .env

Install composer(For Windows OS, --ignore-platform-reqs flag are required to install Horizon)

    $ composer install --ignore-platform-reqs

Run php artisan command

    $ php artisan key:generate
    $ php artisan migrate
    $ php artisan storage:link
