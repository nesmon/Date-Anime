#!/bin/bash

composer run-script post-update-cmd

mkdir -p /home/docker/var/sessions
chmod 777 -R /home/docker/var/cache /home/docker/var/log

exec "$@"
