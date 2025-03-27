FROM robsontenorio/laravel:3.5 AS base
COPY --chown=appuser:appuser . .

FROM base AS local
CMD ["/usr/local/bin/start"]

FROM base AS deploy
RUN COMPOSER_PROCESS_TIMEOUT=600 COMPOSER_IPRESOLVE=4 composer install --prefer-dist --no-interaction --no-progress --ansi
RUN cp .env.example .env
RUN yarn install && yarn build
RUN chmod a+x .docker/deploy.sh
CMD ["/bin/sh", "-c", ".docker/deploy.sh && /usr/local/bin/start"]

