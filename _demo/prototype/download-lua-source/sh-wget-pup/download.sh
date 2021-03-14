#!/usr/bin/env bash

mkdir -p download

cd download

#wget -c --html-extension 'http://www.lua.org/ftp/'
wget -c 'http://www.lua.org/ftp/' -O lua-source.html

cat lua-source.html | pup 'a attr{href}' | grep -e lua -e refman | awk '{print "http://www.lua.org/ftp/"$1}' > lua-source.txt

wget -c -i lua-source.txt
