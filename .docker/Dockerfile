FROM robsontenorio/laravel:3.5 AS base
COPY --chown=appuser:appuser . .

FROM base AS local
# TODO - install globally because conflitct between packages
# RUN composer global require spatie/phpunit-watcher
CMD ["/usr/local/bin/start"]

FROM base AS deploy
RUN composer install --prefer-dist --no-interaction --no-progress --ansi
RUN cp .env.example .env
RUN yarn install && yarn build
RUN chmod a+x .docker/deploy.sh
CMD ["/bin/sh", "-c", ".docker/deploy.sh && /usr/local/bin/start"]

