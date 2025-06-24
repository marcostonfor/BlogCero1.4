#!/bin/bash

sudo chmod -R 750 BlogCero1.3

sudo chown -R marcos:www-data BlogCero1.3

sudo find BlogCero1.3 -type d -exec chmod 750 {} \;
sudo find BlogCero1.3 -type f -exec chmod 640 {} \;

sudo chmod -R g+w BlogCero1.3