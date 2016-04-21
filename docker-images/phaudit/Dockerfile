FROM jolicode/phaudit

USER root

RUN apt-get update && \
    apt-get install -y curl wget && \
    curl -fsSL https://get.docker.com/ | sh && \
    pip install docker-compose==1.7 && \
    pip install ipaddress && \
    pip install functools32 && \
    usermod -G docker travis

USER travis
