#!/bin/bash

# Navigate to the Laravel application's root directory
cd /var/app/current

# Check if the 'framework/views' directory exists, if not, create it
if [ ! -d "storage/framework/views" ]; then
    mkdir -p storage/framework/views
    chmod 777 storage/framework/views
    echo "Created storage/framework/views directory and set permissions to 777."
fi

# Check if the 'framework/cache' directory exists, if not, create it
if [ ! -d "storage/framework/cache" ]; then
    mkdir -p storage/framework/cache
    chmod 777 storage/framework/cache
    echo "Created storage/framework/cache directory and set permissions to 777."
fi
