MoneyLog
=========

Manage your savings. 
Ver: 1.0


How to install:
- get Composer `https://getcomposer.org/download/`
- `git clone` this project
- go to project directory and execute: 
1. `php composer install`
2. ` php bin/console doctrine:schema:update --force` (before that change your database config in `app\config\parameters.yml`)
- run `php bin/console server:start`
- go to `http://localhost:8000` in your browser
