FROM webdevops/php-apache-dev:8.4
RUN apt-get update && apt-get install -y git

# Set up environment for the application user
ENV APP_USER=application
ENV APP_HOME=/home/${APP_USER}
ENV COMPOSER_HOME=${APP_HOME}/.composer
ENV PATH=${COMPOSER_HOME}/vendor/bin:${PATH}

# Create composer home and fix permissions
RUN mkdir -p ${COMPOSER_HOME} && chown -R ${APP_USER}:${APP_USER} ${APP_HOME}

# Install Kirby CMS and Kirby type stubs globally
USER ${APP_USER}
RUN composer global config --no-plugins allow-plugins.getkirby/composer-installer true \
 && composer global require getkirby/cms:^5

# Go back to root for normal operations
USER root

RUN chown -R application:application /app/