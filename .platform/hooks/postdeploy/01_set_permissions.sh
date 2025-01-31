#!/bin/bash

# Set permissions for Laravel storage folder
echo "Setting permissions for Laravel storage folder..."

# Create necessary directories if they do not exist
mkdir -p /var/app/current/storage/framework/sessions
mkdir -p /var/app/current/storage/framework/cache
mkdir -p /var/app/current/storage/framework/views
mkdir -p /var/app/current/storage/logs

# Set proper permissions for the storage directory
sudo chown -R webapp:webapp /var/app/current/storage
sudo chmod -R 775 /var/app/current/storage

# Set permissions for the logs subfolder (you can change this if needed)
sudo chown -R webapp:webapp /var/app/current/storage/logs
sudo chmod -R 775 /var/app/current/storage/logs

# Set permissions for the sessions folder
sudo chown -R webapp:webapp /var/app/current/storage/framework/sessions
sudo chmod -R 775 /var/app/current/storage/framework/sessions

echo "Permissions set successfully."
