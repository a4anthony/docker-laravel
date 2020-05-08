#!/usr/bin/env bash

if [ "$NGINX_SSL" = true ]; then
cat > /etc/nginx/conf.d/default.conf <<- EOF
server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name  www.$DEV_DOMAIN;
    ssl_certificate /etc/nginx/ssl-cert.crt;
    ssl_certificate_key /etc/nginx/ssl-cert.key;
    ssl_protocols       TLSv1 TLSv1.1 TLSv1.2;
    ssl_ciphers         HIGH:!aNULL:!MD5;
    return 301 https://$DEV_DOMAIN\$request_uri;

}
server {
    listen 80;
    listen [::]:80;

    root /var/www/html/public;
    index index.php index.html index.htm;

    server_name $DEV_DOMAIN;
    return 301 https://$DEV_DOMAIN\$request_uri;
}
# server {
#     listen 80;
#     listen [::]:80;

#     root /var/www/html/public;
#     index index.php index.html index.htm;

#     server_name admin.$DEV_DOMAIN ;
#     return 301 https://admin.$DEV_DOMAIN\$request_uri;
# }

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;

    ssl_certificate /etc/nginx/ssl-cert.crt;
    ssl_certificate_key /etc/nginx/ssl-cert.key;
    ssl_protocols       TLSv1 TLSv1.1 TLSv1.2;
    ssl_ciphers         HIGH:!aNULL:!MD5;

    root /var/www/html/public;

    index index.php index.html index.htm index.nginx-debian.html;

    server_name $DEV_DOMAIN *.$DEV_DOMAIN;

    charset utf-8;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        try_files \$uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        #fastcgi_pass melamart-docker-php:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        fastcgi_param PATH_INFO \$fastcgi_path_info;
        fastcgi_pass unix:/socket/php-fpm.sock;
    }

    location ~* \.(?:ico|webp|css|js|gif|jpe?g|png)$ {
        expires max;
        add_header Pragma public;
        add_header Cache-Control "public";
        try_files \$uri =404;
    }

    location ~ \.(?:swf|pdf|mov|fla|zip|rar)$ {
        try_files \$uri =404;
    }
}
EOF
else
cat > /etc/nginx/conf.d/default.conf <<- EOF
server {
    index index.php index.html;
    server_name $DEV_DOMAIN;
    error_log  /var/log/nginx/error_manual.log;
    access_log /var/log/nginx/access_manual.log;
    root /var/www/html/public;
    location ~ \.php$ {
        try_files \$uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass melamart-docker-php:9000;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        fastcgi_param PATH_INFO \$fastcgi_path_info;
    }
}
EOF
fi