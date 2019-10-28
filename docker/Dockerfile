# dockerfile kronos
FROM php:7.2-alpine
ARG WORKSPACE

ARG ssh_prv_key
ARG ssh_pub_key

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini && \
    sed -i -e "s/memory_limit = 128M/memory_limit = 512M/g" /usr/local/etc/php/php.ini

RUN	apk update && \
	apk upgrade && \
	apk add --update git docker curl openssl php7-mysqli php7-dom php7-json php7-tokenizer php7-iconv php7-xmlwriter php7-curl && \
	apk add --update php7-simplexml php7-session php7-pdo php7-pdo_mysql php7-mbstring php7-ldap php7-gd grep && \
	apk add --update libpng libpng-dev curl-dev && \
	apk add --update ruby-full && \
	curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
	chmod +x /usr/local/bin/composer && \
    rm -rf /var/cache/apk/*

RUN gem install bundler -v '1.16.1'

# Install Composer
RUN composer --version
# Set timezone
#RUN rm /etc/localtime
RUN ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime
RUN "date"

RUN docker-php-ext-install zip pdo_mysql ldap curl gd

RUN apk del curl openssl libpng libpng-dev curl-dev openldap-dev

RUN echo 'alias sf="php bin/console"' >> ~/.bashrc

# Add the keys and set permissions
RUN mkdir /root/.ssh && \
    echo "$ssh_prv_key" > /root/.ssh/id_rsa && \
    echo "$ssh_pub_key" > /root/.ssh/id_rsa.pub && \
    chmod 600 /root/.ssh/id_rsa && \
    chmod 600 /root/.ssh/id_rsa.pub

ADD start.sh /bootstrap/
RUN chmod +x /bootstrap/start.sh

EXPOSE 80
ENTRYPOINT ["/bootstrap/start.sh"]