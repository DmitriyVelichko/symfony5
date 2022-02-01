FROM mysql:5.7.37

ADD dump/init.sql /docker-entrypoint-initdb.d/init.sql

RUN chown -R mysql:mysql /docker-entrypoint-initdb.d

CMD ["mysqld", "--character-set-server=utf8mb4", "--collation-server=utf8mb4_unicode_ci"]