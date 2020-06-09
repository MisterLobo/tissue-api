#!/usr/bin/env bash

htpasswd -cb .htpasswd "$1" "$2"
DIR=$(pwd)/.htpasswd
sed -i -e '1s@#AuthUserFile@AuthUserFile '"$DIR"'@' -e '2s@#AuthName@AuthName@' .htaccess -e '3s@#AuthType@AuthType@' -e '4s@#require@require@' .htaccess
