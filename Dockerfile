FROM php:8.1-apache

#COPY src/ /var/www/html/

USER nobody

EXPOSE 80

CMD tail -f /dev/null