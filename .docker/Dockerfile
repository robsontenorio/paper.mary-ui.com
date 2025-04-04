# Base
FROM robsontenorio/laravel:franken-classic AS base
COPY --chown=appuser:appuser . .

# Production
FROM base AS deploy
RUN chmod a+x .docker/deploy.sh
CMD ["/bin/sh", "-c", ".docker/deploy.sh && start"]

