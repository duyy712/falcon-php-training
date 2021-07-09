test:
	vendor/bin/phpcs --standard=phpcs.xml && vendor/bin/phpmd app text phpmd.xml
start:
	php artisan serve
init:
	composer install
	npm install
	php artisan key:generate
	php artisan serve
