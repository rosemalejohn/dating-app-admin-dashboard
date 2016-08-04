# Dating User Moderator Admin Dashboard

User moderator dashboard for various dating app managed by n8core.

# Installation Requirements

- git
- bower
- node.js
- composer

# Installation

- Clone this repo by running `git clone https://github.com/rosemalejohn/dating-app-admin-dashboard.git`
- cd to the cloned directory and run `composer install`
- run `npm install` and `bower install` to download the node_modules and bower_dependencies respectively
- run `gulp` or `gulp --production` to compile and minify assets

# Database setup

- create a database
- open .env file in the root directory and fill in the required credentials
- run `php artisan migrate` to create tables
- run `php artisan db:seed` to create the required database inputs

# Allowing ports to firewall (CENTOS 6)

- `sudo iptables -I INPUT -p tcp -m tcp --dport 3000 -j ACCEPT`
- `sudo service iptables save`