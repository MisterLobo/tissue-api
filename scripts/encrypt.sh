#!/usr/bin/env bash

PASSPHRASE=$1
FILE=$2

echo "$PASSPHRASE" | gpg --symmetric --batch --yes --cipher-algo AES256 --passphrase-fd 0 "$FILE"

