# Base
FROM robsontenorio/laravel:franken-1.0 AS base
COPY --chown=appuser:appuser . .

# Production
FROM base AS production
ENV RUN_DEPLOY=true

