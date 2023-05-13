FROM debian:11

WORKDIR /
RUN set -eu && \
	apt-get update && \
	apt-get upgrade --no-install-recommends -y && \
	apt-get install --no-install-recommends -y ca-certificates apache2 mariadb-server mariadb-client php php-all-dev php-illuminate-database && \
	rm -rf /var/www/html/*
COPY dock/startservs.sh dock/initperms.sql initdb.sql /
RUN service mariadb start && \
	mysql -sfu root < "initperms.sql" && \
	mysql --password=password --user=root < "initdb.sql" && \
	mkdir /defmysql && \
	mv /var/lib/mysql/* /defmysql/
CMD ["bash", "/startservs.sh"]

