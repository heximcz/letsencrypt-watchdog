# Let's Encrypt Watchdog


## Overview

Let's Encrypt watchdog is simply guard your domain certificate. If certificate expire during 24 hours, this script renew it.

## Current State

version 0.0.1
first functionality is fully tested on debian like system with Let's Encrypt Public Beta

## How Install Let's Watchdog

 - Connet via SSH to your web server
 - ```cd /opt/```
 - ```git clone https://github.com/heximcz/letsencrypt-watchdog.git```
 - ```cd /opt/letsencrypt-watchdog/```
 - ```cp ./config.default.yml ./config.yml```
 - change your preferences in the config.yml file

## Example Usage

print help:

```php ./lets-watchdog.php```

or

```php ./lets-watchdog.php wd:simple -h```

check all and renew certificate who will be expired during 24 hours:

```php ./lets-watchdog.php wd:simple```

### Using via crontab

add this line to your /etc/crontab:

```0 0  * * *   root /usr/local/sbin/php /opt/letsencrypt-watchdog/lets-watchdog.php wd:simple >> /var/log/le-watchdog/lewatchdog.log```
