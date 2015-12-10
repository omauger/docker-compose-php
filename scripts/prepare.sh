# Composer install
docker run --rm -u $UID:www-data -v $PWD:$PWD -w $PWD composer/composer install || exit 1
