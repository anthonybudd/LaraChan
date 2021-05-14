#!/bin/bash

echo ''
echo 'LARACHAN TOR PROXY'
echo ''

if [ "$1" == "generate" ]
then
    if [ -f /web/private_key ]
    then
        echo '* You already have an private key, delete it if you want to generate a new key'
        exit -1
    fi
    if [ -z "$2" ]
    then
        $2='lc^'
    else
        shallot -f /tmp/key $2
        echo '* '$(grep Found /tmp/key)
        grep 'BEGIN RSA' -A 99 /tmp/key > /web/private_key
    fi

    address=$(grep Found /tmp/key | cut -d ':' -f 2 )
    echo $address > /web/hostname
    
    echo 'server {' > /web/site.conf
    echo '  listen 127.0.0.1:8080;' >> /web/site.conf
    echo '  server_name '$address';' >> /web/site.conf
    echo '  ignore_invalid_headers off;' >> /web/site.conf
    echo '  client_max_body_size 0;' >> /web/site.conf
    echo '  proxy_buffering off;' >> /web/site.conf
    echo '' >> /web/site.conf
    echo '  location / {' >> /web/site.conf
    echo '    proxy_pass http://larachan:80;' >> /web/site.conf
    echo '    proxy_set_header X-Real-IP $remote_addr;' >> /web/site.conf
    echo '    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;' >> /web/site.conf
    echo '    proxy_set_header X-Forwarded-Proto $scheme;' >> /web/site.conf
    echo '    proxy_set_header Host $http_host;' >> /web/site.conf
    echo '    proxy_http_version 1.1;' >> /web/site.conf
    echo '    proxy_set_header Connection "";' >> /web/site.conf
    echo '    chunked_transfer_encoding off;' >> /web/site.conf
    echo '  }' >> /web/site.conf
    echo '}' >> /web/site.conf

    chmod 700 /web

fi

if [ "$1" == "serve" ]
then
    if [ ! -f /web/private_key ]
    then
        echo '* Please run this container with generate argument to initialize tor-proxy'
        exit -1
    fi
    echo '* Initializing local clock'
    ntpdate -B -q 0.debian.pool.ntp.org
    echo '* Starting tor'
    tor -f /etc/tor/torrc &
    echo '* Starting nginx'
    nginx &
    sleep infinity
fi
