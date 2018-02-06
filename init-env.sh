#!/bin/bash
# Init env on ubuntu 14.04 with php 5 (replace to 7)

sudo apt-get update
sudo apt-get dist-upgrade -y
sudo apt-get install software-properties-common
sudo add-apt-repository -y ppa:ondrej/php
sudo apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 4F4EA0AAE5267A6C
sudo apt-get remove -y php5
sudo apt-get update
sudo apt-get install -y php7.0 php7.0-mysql libapache2-mod-php7.0 php7.0-phalcon php7.0-sqlite3
sudo apt-get autoremove -y