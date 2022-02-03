# symfony5
Прежде чем запустить сборку, нужно убедиться что в каталоге docker/database/mysql пусто.
Запустить сборку:
cd docker
docker-compose build
Проверить mysql ещё раз, чтобы в нём не было файлов.
Запуск контейнеров
docker-compose up -d
Проверяем запущеные контейнеры:
docker-compose ps
в списке должно быть php database phpmyadmin nginx

Все нюансы по настройки будут пофикшены в процесси доработок.
Список того, что сделал:
1) Содал конфиг для запуска Docker
2) Настроил конфиги nginx + php + mysql
3) Сгенерировал Entity + Repository
4) Сгенерировал Migration
5) Настроил связи таблиц + ключи
6) Создал методы для создания и получения данных
7) UNIT-test
8) Локализация контента


Для создания автора:
/author/create?name=Автор123456

Поиск автора:
/author/search?name=Автор123456

Создание книги:
/ru/book/create?name=Новая книга&author=Автор123456

Поиск:
/ru/book/search?name=Новая книга
/ru/book/1


Не забудье накатить миграции:
из контейнера php
docker exec -u root -t -i php /bin/bash
cd project
php bin/console doctrine:migrations:migrate

Чтобы запустить тесты:
php ./vendor/bin/phpunit


Это не финальная версия. Функционал работает, но код нужно привести в порядок.