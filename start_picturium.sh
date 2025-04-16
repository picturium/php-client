#!/bin/bash

docker run \
  --name picturium-php-client \
  -dt \
  --init \
  --user=root \
  -v "./.env:/app/.env" \
  -v "./data:/app/data" \
  -p 20045:20045 \
  -w /app \
  lamka02sk/picturium:latest
