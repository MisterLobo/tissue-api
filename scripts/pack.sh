#!/usr/bin/env bash

rm -rf vault/
rm vault.tar.gz
mkdir vault

cp devenv vault/
cp demoenv vault/
cp env vault/
cp cienv vault/

cp ./scripts/encrypt.sh vault

cd vault || exit

./encrypt.sh "$1" devenv
./encrypt.sh "$1" demoenv
./encrypt.sh "$1" env
./encrypt.sh "$1" cienv

rm ./encrypt.sh
rm ./devenv
rm ./demoenv
rm ./env
rm ./cienv

cd ..

./scripts/ctar.sh vault.tar.gz vault/
./scripts/encrypt.sh "$1" vault.tar.gz

rm -rf vault/
