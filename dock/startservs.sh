#!/bin/bash
# starts the services required to run stuff (services in the container can't be autostarted)

set -eu
mv -n /defmysql/* /var/lib/mysql/
mkdir -p /defmysql
service mariadb start
service apache2 start
sleep 2147483647
# sleep so the container won't exit

