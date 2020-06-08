#!/usr/bin/env bash

command -v deb
deb http://archive.ubuntu.com/ubuntu focal main restricted #Added by software-properties
deb http://ph.archive.ubuntu.com/ubuntu/ focal restricted main universe multiverse #Added by software-properties
deb http://ph.archive.ubuntu.com/ubuntu/ focal-updates restricted main universe multiverse #Added by software-properties
deb http://ph.archive.ubuntu.com/ubuntu/ focal-backports main restricted universe multiverse #Added by software-properties
deb http://security.ubuntu.com/ubuntu focal-security restricted main universe multiverse #Added by software-properties
deb http://ph.archive.ubuntu.com/ubuntu/ focal-proposed restricted main universe multiverse #Added by software-properties
