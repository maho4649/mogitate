#!/bin/bash
# MySQLが立ち上がるまで待機
until mysql -h mysql -u laravel_user -p'laravel_pass' -e 'select 1'; do
  echo "Waiting for MySQL to start..."
  sleep 2
done

# Laravel migrationを実行
php artisan migrate

# PHPのメインプロセスを起動
php-fpm


