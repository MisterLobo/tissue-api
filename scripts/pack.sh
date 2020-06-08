#!/usr/bin/env bash

rm -rf vault/
rm vault.tar.gz
mkdir vault

cp devenv vault/
cp demoenv vault/
cp env vault/
cp cienv vault/

cp ciftpenv vault/
cp ciftpenv_dev vault/
cp ciftpenv_demo vault/

cp ./scripts/encrypt.sh vault

cd vault || exit

./encrypt.sh "$1" devenv
./encrypt.sh "$1" demoenv
./encrypt.sh "$1" env
./encrypt.sh "$1" cienv

./encrypt.sh "$1" ciftpenv
./encrypt.sh "$1" ciftpenv_dev
./encrypt.sh "$1" ciftpenv_demo

rm ./encrypt.sh
rm ./devenv
rm ./demoenv
rm ./env
rm ./cienv
rm ./ciftpenv
rm ./ciftpenv_dev
rm ./ciftpenv_demo

cd ..

./scripts/ctar.sh vault.tar.gz vault/
./scripts/encrypt.sh "$1" vault.tar.gz
mv vault.tar.gz.gpg vault.gpg

rm vault.tar.gz
rm -rf vault/
