FROM m:13.1

RUN mkdir -p /docker-entrypoint-initdb.d

COPY ./docker/db/add-unaccent-extensions.sh /docker-entrypoint-initdb.d/add-unaccent-extensions.sh
RUN chmod +x /docker-entrypoint-initdb.d/add-unaccent-extensions.sh
