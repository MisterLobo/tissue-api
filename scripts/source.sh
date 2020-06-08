#!/usr/bin/env bash

cat /etc/apt/sources.list
sudo cp /etc/apt/sources.list /etc/apt/sources2.list
sudo tee --append /etc/apt/sources.list <<CONTENT
deb http://archive.ubuntu.com/ubuntu focal main restricted \
deb http://ph.archive.ubuntu.com/ubuntu/ focal restricted main universe multiverse \
deb http://ph.archive.ubuntu.com/ubuntu/ focal-updates restricted main universe multiverse \
deb http://ph.archive.ubuntu.com/ubuntu/ focal-backports main restricted universe multiverse \
deb http://security.ubuntu.com/ubuntu focal-security restricted main universe multiverse \
deb http://ph.archive.ubuntu.com/ubuntu/ focal-proposed restricted main universe multiverse \
/etc/apt/sources.list
CONTENT
