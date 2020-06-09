#!/usr/bin/env bash

PASSPHRASE=$1
FILE=$2
OUTFILE=$3

echo Decrypting "$FILE" ...
gpg --quiet --batch --yes --decrypt --passphrase="$PASSPHRASE" --output ./"$OUTFILE" "$FILE"
echo Decrypted "$FILE"
echo Created "$OUTFILE"
