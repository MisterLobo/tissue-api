#!/usr/bin/env bash

PASSPHRASE=$DEV_GPG_SECRET
FILE=devenv.gpg

gpg --quiet --batch --yes --decrypt --passphrase="$PASSPHRASE" --output ./devenv "$FILE"
