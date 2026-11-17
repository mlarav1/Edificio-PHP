# ============================================================
# Imagen para ejecutar el CRUDL de Edificios (PHP 8.3 + Apache)
# Compatible con Render (usa la variable PORT).
# ============================================================
FROM php:8.3-apache

# Extensiones requeridas: PDO MySQL (mbstring ya viene incluida en la imagen oficial)
RUN docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite headers

# El .htaccess del proyecto necesita AllowOverride All
RUN sed -ri 's!AllowOverride None!AllowOverride All!g' /etc/apache2/apache2.conf \
    && printf '<Directory /var/www/html>\n    AllowOverride All\n    Require all granted\n</Directory>\n' > /etc/apache2/conf-available/app.conf \
    && a2enconf app

WORKDIR /var/www/html
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENV PORT=10000
EXPOSE 10000

ENTRYPOINT ["entrypoint.sh"]
CMD ["apache2-foreground"]