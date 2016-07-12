FROM ubuntu:latest
MAINTAINER Ricardo Telles <rtelles@webeleven.com.br>

RUN mkdir /downloads /teste /scripts; \
    echo 'PATH=$PATH:/scripts' >> /etc/profile; \
    echo "alias l='ls -lah --color'" >> /etc/bash.bashrc; \
    echo "alias vi=vim" >> /etc/bash.bashrc

RUN echo '* hard nofile 500000' >> /etc/security/limits.conf; \
    echo '* soft nofile 500000' >> /etc/security/limits.conf; \
    echo 'root hard nofile 500000' >> /etc/security/limits.conf; \
    echo 'root soft nofile 500000' >> /etc/security/limits.conf; \
    echo 'fs.file-max = 2097152' >> /etc/sysctl.conf

RUN rm -rf /etc/localtime; \
    ln -s /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime; \
    echo '00 */1 * * * root ntpdate 0.br.pool.ntp.org >> /var/log/messages 2>&1' >> /etc/crontab

RUN apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get -yq install \
      apt-utils\
      iputils-ping \
      file \
      mlocate \
      wget \
      vim \
      netstat-nat \
      unzip \
      curl \
      elinks \
      telnet \
      ntpdate \
      bash-completion \
      perl \
      python \
      net-tools \
      lsof \
      git \
      psmisc \
      sgml-base \
      ucf \
      xml-core \
      mime-support \
      nginx \
      php7.0-fpm \
      php7.0 \
        php7.0-cli \
        php7.0-common \
        php7.0-curl \
        php7.0-gd \
        php7.0-json \
        php7.0-mysql \
        php7.0-opcache \
        php7.0-xml \
        php7.0-mbstring \
        php7.0-mcrypt \
        php7.0-soap \
        php7.0-xml \
        php7.0-readline \
      libbsd0 \
      libedit2 \
      libicu55 \
      libmagic1 \
      libssl1.0.0 \
      libxml2

RUN wget -P /downloads/ https://s3.amazonaws.com/aws-cli/awscli-bundle.zip; \
    unzip -d /downloads/ /downloads/awscli-bundle.zip; \
    /downloads/awscli-bundle/install -i /usr/local/aws -b /usr/local/bin/aws; \
    rm -rf /downloads/*

RUN cd /downloads/; \
    curl -sS https://getcomposer.org/installer | php; \
    mv composer.phar /usr/local/bin/composer; \
    chmod +x /usr/local/bin/composer

RUN composer global require "laravel/installer=~1.1"; \
    mv ~/.composer /usr/local/bin/laravel; \
    echo 'PATH=$PATH:/usr/local/bin/laravel/vendor/bin' >> /etc/profile

RUN apt-get clean; \
    apt-get autoclean

RUN rm -f /etc/php/7.0/cli/php.ini; \
    rm -f /etc/php/7.0/fpm/pool.d/www.conf; \
    wget -P /etc/php/7.0/cli/ https://s3-sa-east-1.amazonaws.com/tools.infra.web11.com.br/docker-auth/php.ini; \
    wget -P /etc/php/7.0/fpm/pool.d/ https://s3-sa-east-1.amazonaws.com/tools.infra.web11.com.br/docker-auth/www.conf

RUN wget -P /scripts/ https://s3-sa-east-1.amazonaws.com/tools.infra.web11.com.br/docker-auth/init.sh; \
    chmod +x /scripts/init.sh

# This needs to be altered if the session is not handled locally (ex.: Elasticache)
RUN useradd nginx; \
    mkdir -p /var/run; \
    mkdir -p /var/lib/php/session; \
    chown nginx.nginx /var/lib/php/session; \
    mkdir -p /run/php; \
    chown nginx.nginx /run/php

RUN touch /var/log/nginx/access.log; \
    touch /var/log/php7.0-fpm.log

RUN mkdir -p /var/app; \
    chown nginx.nginx /var/app; \
    chmod 775 /var/app; \
    chmod +x /var
    
RUN mkdir -p /scripts/deploy-app; \
    chown nginx.nginx /scripts/deploy-app; \
    wget -P /scripts/deploy-app/ https://s3-sa-east-1.amazonaws.com/tools.infra.web11.com.br/docker-auth/git-prep.sh; \
    wget -P /scripts/deploy-app/ https://s3-sa-east-1.amazonaws.com/tools.infra.web11.com.br/docker-auth/deploy-app.sh; \
    chmod +x /scripts/deploy-app/deploy-app.sh; \
    chmod +x /scripts/deploy-app/git-prep.sh; \
    /scripts/deploy-app/git-prep.sh

# PHP Production - Enable for production (Don't forget to change the file content to match the application!!!)
# RUN /scripts/deploy-app/deploy-app.sh

# PHP Test - Disable for Production
# RUN wget -P /var/app/ https://raw.githubusercontent.com/telles-webeleven/docker-files/master/index.php; \
ADD ./ /var/app

RUN rm -f /etc/nginx/nginx.conf; \
    rm -f /etc/nginx/sites-available/default; \
    rm -f /etc/nginx/sites-enable/default; \
    rm -f /etc/nginx/sites-enabled/default; \
    wget -P /etc/nginx/ https://s3-sa-east-1.amazonaws.com/tools.infra.web11.com.br/docker-auth/nginx.conf; \
    wget -P /etc/nginx/conf.d/ https://s3-sa-east-1.amazonaws.com/tools.infra.web11.com.br/docker-auth/default.conf

CMD ["/scripts/init.sh"]
