FROM webdevops/php-apache-dev:8.4
RUN apt-get update && apt-get install -y git
RUN chown -R application:application /app/