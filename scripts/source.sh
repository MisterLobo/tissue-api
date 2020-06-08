#!/usr/bin/env bash

cat /etc/apt/sources.list
sudo cp /etc/apt/sources.list /etc/apt/sources2.list
cat < ./etc/apt/sources.list | sudo tee -a /etc/apt/sources.list > /dev/null
cat /etc/apt/sources.list
