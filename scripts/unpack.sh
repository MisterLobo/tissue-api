#!/usr/bin/env bash

chmod +x ./scripts/decrypt.sh
chmod +x ./scripts/xtar.sh
./scripts/decrypt.sh "$1" vault.gpg vault.tar.gz
./scripts/xtar.sh vault.tar.gz

cp ./scripts/decrypt.sh vault

cd vault || exit

./decrypt.sh "$1" "$2".gpg "$2"
./decrypt.sh "$1" cienv.gpg cienv

./decrypt.sh "$1" "$3" ftpenv

cp devenv ../
cp cienv ../
cp ftpenv ../

ls -al

cd ..

ls -al

# rm vault.tar.gz
# rm -rf vault/
