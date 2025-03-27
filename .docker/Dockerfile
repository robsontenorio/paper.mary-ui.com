FROM robsontenorio/laravel:3.5 AS base
COPY --chown=appuser:appuser . .

FROM base AS local
CMD ["/usr/local/bin/start"]

FROM base AS deploy
USER root
RUN curl -sS https://getcomposer.org/installer  | php -- --install-dir=/usr/bin --filename=composer
USER appuser
RUN composer install --prefer-dist --no-interaction --no-progress --ansi
RUN cp .env.example .env
RUN yarn install && yarn build
RUN chmod a+x .docker/deploy.sh
CMD ["/bin/sh", "-c", ".docker/deploy.sh && /usr/local/bin/start"]

