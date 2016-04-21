# Composer install
docker run --rm -u $UID:www-data -v $PWD:$PWD -w $PWD composer/composer install || exit 1
docker build -t docker/phaudit:latest docker-images/phaudit
