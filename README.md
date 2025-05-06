## Dockerビルド
1. git clone git@github.com:maho4649/mogitate.git
2. cd mogitate
3. docker-compose up -d --build


## Laravel環境構築
1. docker-compose exec php bash
2. composer install
3. cp .env.exampleファイルから.envを作成し、環境変数を変更
4. php artisan key:generate
5. php artisan migrate
6. php artisan db:seed


## 使用技術
PHP 8.2.28  
Laravel Framework 8.83.29  
mysql  Ver 9.2.0 for macos15.2 on arm64 (Homebrew)  
  
URL  
開発環境:http://localhost/  
phpMyAdmin:http://localhost:8080  

商品一覧  
/products  
商品詳細  
/products/{productId}  
商品更新  
/products/{productId}/update  
商品登録  
/products/register  
検索  
/products/search  
削除  
/products/{productId}/delete
