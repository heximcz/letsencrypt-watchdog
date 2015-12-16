# Let's Encrypt Watchdog


## Overview

Let's Encrypt watchdog is simply guard your domain certificate. If certificate expire during 24 hours, this script renew it.

## Current State

version 0.0.1
first functionality is full tested

## How Install Let's Watchdog

 - Connet via SSH to your web server
 - ```cd /opt/```
 - ```git clone https://github.com/heximcz/letsencrypt-watchdog.git```
 - ```cd /opt/letsencrypt-watchdog/```
 - ```cp ./config.default.yml ./config.yml```
 - change your preferences in the config.yml file

## Example Usage

print help

```php ./lets-watchdog.php```

check all and renew certificate who will be expired during 24 hours 

```php ./lets-watchdog.php wd:simple```
