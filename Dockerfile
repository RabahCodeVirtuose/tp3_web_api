FROM php:8.4-fpm-alpine
LABEL AUTHOR="Frédéric Loulergue"
ARG USERNAME
ARG USERID
ARG EMAIL

RUN echo "$USERNAME ($USERID): $EMAIL"

# installation bash
RUN apk --no-cache update && apk --no-cache add bash git npm shadow

# installation de composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
&& php composer-setup.php --install-dir=/usr/local/bin \
&& php -r "unlink('composer-setup.php');"

# installation de symfony
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash
RUN apk add symfony-cli


# Gestion user
RUN echo "UID_MAX $UID" > /etc/login.defs
RUN /usr/sbin/useradd --create-home -s /bin/sh -u "$USERID" "$USERNAME"
USER $USERNAME

# config git
RUN git config --global user.email $EMAIL
RUN git config --global user.name $USERNAME

WORKDIR /var/html/www
CMD [ "/bin/bash" ] 