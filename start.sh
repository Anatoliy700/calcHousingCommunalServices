#!/usr/bin/env bash

open http://127.0.0.1:8085

DIR=$(dirname $0)
php -S 127.0.0.1:8085 -t $DIR/web/

