#!/bin/sh

yarn && yarn build
pm2 restart laranuxt
