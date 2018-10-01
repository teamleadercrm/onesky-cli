FROM php:7-cli-alpine

# Install composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/bin/composer

# Copy source code
COPY . /source

# Install dependencies
RUN cd source && composer install

# Run onesky cli command
ENTRYPOINT ["/source/bin/onesky"]
