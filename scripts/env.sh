#!/usr/bin/env bash

PASSPHRASE=$PROD_GPG_SECRET
FILE=env.gpg

gpg --quiet --batch --yes --decrypt --passphrase="$PASSPHRASE" --output ./env "$FILE"
