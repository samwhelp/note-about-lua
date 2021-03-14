#!/usr/bin/env bash

mkdir -p download

cd download

wget -c 'http://www.lua.org/ftp/' -O raw.html

xmllint --html --format raw.html > lua-source.html

cat lua-source.html | grep -Po 'href=\".*?\"' | grep -Po '="\K[^"]+' | grep -e lua -e refman | awk '{print "http://www.lua.org/ftp/"$1}' > lua-source.txt

wget -c -i lua-source.txt
