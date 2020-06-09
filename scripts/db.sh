#!/usr/bin/env bash

CONN=$1

sed -i -e '1s/=/='"$CONN"'/' .env
