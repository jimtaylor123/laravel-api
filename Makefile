setup:
	cp .env.example .env 
	composer install
	php artisan key:generate
	npm install
	php artisan serve