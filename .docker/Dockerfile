FROM robsontenorio/laravel:3.5 AS base
COPY --chown=appuser:appuser . .

FROM base AS local
CMD ["/usr/local/bin/start"]

FROM base AS deploy
RUN chmod a+x .docker/deploy.sh
CMD ["/bin/sh", "-c", ".docker/deploy.sh && /usr/local/bin/start"]

