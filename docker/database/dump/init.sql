# -- DATABASE
# CREATE DATABASE IF NOT EXISTS symfony_base CHARACTER SET utf8 COLLATE utf8_general_ci;
# -- USER
# DROP USER dmitry;
# FLUSH PRIVILEGES;
#
# CREATE USER IF NOT EXISTS 'dmitry'@'localhost' IDENTIFIED WITH mysql_native_password BY 'root';
# GRANT ALL ON `symfony_base`.* TO 'dmitry'@'localhost' IDENTIFIED WITH mysql_native_password BY 'root';
# FLUSH PRIVILEGES;
#
# -- TABLES
# USE symfony_base;
#
# CREATE TABLE author
# (
#     id   int auto_increment primary key,
#     name varchar(255) not null unique
# ) ENGINE = InnoDB
#   DEFAULT CHARSET = utf8mb4_general_ci;
#
# CREATE TABLE book
# (
#     id        int auto_increment primary key,
#     name      varchar(255) not null unique,
#     author_id int          not null references author (id),
#     lang      tinytext     not null,
#     FOREIGN KEY (author_id) REFERENCES author (id)
# ) ENGINE = InnoDB
#   DEFAULT CHARSET = utf8mb4_general_ci;
#
# CREATE INDEX book_author_id_index
#     ON book (author_id);