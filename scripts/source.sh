#!/usr/bin/env bash

cat /etc/apt/sources.list
sudo cp /etc/apt/sources.list /etc/apt/sources2.list
sudo cat ./etc/apt/sources.list | sudo tee -a /etc/apt/sources.list
cat /etc/apt/sources.list
