#!/bin/sh

cd /home/redis-3.2.2
src/redis-server &

cd /home/mach1/public_html
npm start