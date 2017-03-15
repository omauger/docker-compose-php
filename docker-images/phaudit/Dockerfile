FROM jolicode/phaudit

USER root

RUN wget https://phar.phpunit.de/phpunit-5.0.phar && \
    mv phpunit-5.0.phar /usr/local/bin/phpunit && \
    chmod +x /usr/local/bin/phpunit && \
    apt-get update && \
    apt-get install -y curl wget && \
    curl -fsSL https://get.docker.com/ | sh && \
    pip install docker-compose==1.7 && \
    pip install ipaddress && \
    pip install functools32 && \
    usermod -G docker travis

USER travis
