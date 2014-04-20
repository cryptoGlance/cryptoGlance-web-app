#!/bin/bash
# cryptoGlance permission fix script for apache2

sudo chown -R www-data *
sudo chmod -R 777 user_data
sudo service apache2 restart