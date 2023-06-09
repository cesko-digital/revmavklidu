#!/bin/bash

rm -f revmavklidu-plugin.zip;
zip -r revmavklidu-plugin.zip \
	vendor/*.* \
	src/*.* \
	composer \
	composer.json \
	composer.lock \
	revmavklidu.php \
	-x '*.log';

