#!/bin/bash

# Create CRON job for Laravel's scheduler
echo "* * * * * root /usr/bin/php /var/app/current/artisan schedule:run 1>> /dev/null 2>&1" \
  | sudo tee /etc/cron.d/artisan_scheduler

# Set the correct permissions for the cron file
sudo chmod 644 /etc/cron.d/artisan_scheduler

# Ensure cron daemon is running and reload cron jobs
sudo service crond restart
