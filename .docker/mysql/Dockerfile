FROM mysql:lts
LABEL authors="Alisson"

RUN usermod -u 1000 mysql

ADD ./initdb.sql /docker-entrypoint-initdb.d



