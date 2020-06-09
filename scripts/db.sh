#!/usr/bin/env bash

CONN=$1
ENV=$2

sed -i -e '2s=/='"$ENV"'/' .env
sed -i -e '3s/=/='"$CONN"'/' .env
