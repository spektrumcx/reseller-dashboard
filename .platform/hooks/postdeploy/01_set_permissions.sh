#!/bin/bash

# Set permissions for Laravel storage folder
echo "Setting permissions for Laravel storage folder..."

# Set proper permissions for the storage directory
sudo chown -R webapp:webapp /var/app/current/storage
sudo chmod -R 775 /var/app/current/storage

# Set permissions for the logs subfolder (you can change this if needed)
sudo chown -R webapp:webapp /var/app/current/storage/logs
sudo chmod -R 775 /var/app/current/storage/logs

echo "Permissions set successfully."
