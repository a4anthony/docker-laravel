FROM nginx:1.15.0-alpine

ARG DEV_DOMAIN
ARG NGINX_SSL
ENV DEV_DOMAIN $DEV_DOMAIN
ENV NGINX_SSL $NGINX_SSL

RUN apk update && apk add \
    openssl \
    bash
    
# RUN addgroup -g 1000 -S www-data
# RUN adduser -u 1000 -S -G www-data www-data

COPY ssl/generate-ssl.sh /etc/nginx/generate-ssl.sh
RUN chmod +x /etc/nginx/generate-ssl.sh
RUN cd /etc/nginx && ./generate-ssl.sh

COPY vhosts/vhost.sh /etc/nginx/vhost.sh
RUN chmod +x /etc/nginx/vhost.sh
RUN cd /etc/nginx && ./vhost.sh

COPY ./nginx.sh /etc/nginx/nginx.sh
RUN chmod +x /etc/nginx/nginx.sh
RUN cd /etc/nginx && ./nginx.sh

RUN addgroup -g 1000 -S www-data && adduser -u 1000 -D -S -G www-data www-data

EXPOSE 80
EXPOSE 443