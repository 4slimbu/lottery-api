FROM php:7.2-fpm

ARG D_USER_ID
ARG D_USER
ARG D_GROUP_ID
ARG D_GROUP

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libxml2-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql soap mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Add group
# If group exist and throws error, simply ignore it and move on
RUN groupadd -f -g $D_GROUP_ID $D_GROUP

# Add user if not exits
RUN useradd -u $D_USER_ID -ms /bin/bash -g $D_GROUP $D_USER || echo "User already exists"

# Copy existing application directory contents
# use this if you want isolated filesystem -e.g: in production
#
# Here I am commenting this because we are mapping the current directory to working
# directory and have also set the same user in .env file so there should not be any
# permission related issue.
#
# COPY . /var/www
# Copy existing application directory permissions
# COPY --chown=$D_USER:$D_GROUP . /var/www



# Set current user
USER $D_USER

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
