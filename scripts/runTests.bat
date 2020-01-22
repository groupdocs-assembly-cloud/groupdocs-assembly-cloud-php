if not exist vendor docker run --rm -v %cd%:/app composer/composer:latest require --dev phpunit/phpunit ^6.0
docker run -v %cd%:/app -w /app --rm phpunit/phpunit:6.0.6 -c phpunit.xml