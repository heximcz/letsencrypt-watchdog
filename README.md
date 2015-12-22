# Let's Encrypt Watchdog


## Overview

Let's Encrypt Watchdog is simply a guard for your domain certificate. If your certificate will expire within 24 hours, this script will renew it.

## Current State

Release 0.0.2

new features: revoke/renew one or all certificates


## Prerequisites

openssl

php > 5.6.x (with enable shell_exec function in php.ini)

## How Install Let's Watchdog

 - Connet via SSH to your web server
 - ```cd /opt/```
 - ```git clone https://github.com/heximcz/letsencrypt-watchdog.git```
 - ```cd /opt/letsencrypt-watchdog/```
 - ```cp ./config.default.yml ./config.yml```
 - ```mkdir -p /var/log/le-watchdog/```
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

### Notice

Limits in Let's Encrypt public beta you can see here:

[Quick Start Guide](https://community.letsencrypt.org/t/quick-start-guide/1631)
