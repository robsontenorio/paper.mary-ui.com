FROM robsontenorio/laravel:2.4 as base
COPY --chown=appuser:appuser . .

FROM base as local
# TODO - install globally because conflitct between packages
# RUN composer global require spatie/phpunit-watcher
CMD ["/usr/local/bin/start"]

FROM base as deploy
RUN chmod a+x .docker/deploy.sh
CMD ["/bin/sh", "-c", ".docker/deploy.sh && /usr/local/bin/start"]

