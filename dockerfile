FROM php:8.2-apache

# Installation des extensions nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Activation des modules Apache nécessaires
RUN a2enmod rewrite

# Définition du répertoire de travail
WORKDIR /var/www/html

# Copie des fichiers du projet vers le conteneur
COPY . /var/www/html/

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Installation des dépendances de Slim Framework
WORKDIR /var/www/html/service/v1
RUN composer install --no-dev --optimize-autoloader

WORKDIR /var/www/html/service/v2
RUN composer install --no-dev --optimize-autoloader

# Retour au répertoire de base
WORKDIR /var/www/html

# Attribution des permissions
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Exposition du port 80
EXPOSE 80

# Démarrage d'Apache
CMD ["apache2-foreground"]