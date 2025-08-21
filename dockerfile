FROM php:8.4.3-apache

# Installation des extensions nécessaires
RUN apt-get update && apt-get install -y zip unzip git \
    && docker-php-ext-install pdo pdo_mysql

# Activation des modules Apache nécessaires
RUN a2enmod rewrite

# Définition du répertoire de travail
WORKDIR /var/www/html

# Copie des fichiers du projet vers le conteneur
COPY . /var/www/html/

# # Installation de Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Installation des dépendances de Slim Framework
# RUN composer install --no-dev --optimize-autoloader

# Attribution des permissions
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Exposition du port 80
EXPOSE 1800

# Démarrage d'Apache
CMD ["php", "-S", "0.0.0.0:1800", "-t", "public"]