#!/usr/bin/env bash

CONN=$1

sed '1s/=/='"$CONN" .env
