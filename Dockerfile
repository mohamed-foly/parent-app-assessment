FROM m0foly/phuntfx:v2

COPY --chown=www-data:www-data . /var/www/

RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer && \
	cd /var/www/ && \
	composer install --prefer-dist --ignore-platform-reqs && \
	php artisan storage:link && \
	# php artisan config:cache && \
	php artisan event:cache && \
	php artisan route:cache && \
	php artisan view:cache

CMD ["/usr/bin/supervisord"]

