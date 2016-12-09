node { // <1>
    stage('Build') { // <2>
        composer self-update
        composer install --no-interaction --prefer-source --dev
        php artisan migrate --force
        php artisan key:generate
        mysql -e "create database IF NOT EXISTS eksiborsa;" -uroot
    }
    stage('Test') {
        vendor/bin/phpunit --coverage-clover=coverage.xml
        wget https://scrutinizer-ci.com/ocular.phar
        php ocular.phar code-coverage:upload  --format=php-clover coverage.xml
        bash <(curl -s https://codecov.io/bash)
    }
    stage('Deploy') {
        /* .. snip .. */
    }
}