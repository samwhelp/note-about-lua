#!/usr/bin/env bash

mkdir -p download

cd download

#wget -c --html-extension 'https://bitop.luajit.org/download.html'
wget -c 'https://bitop.luajit.org/download.html' -O bitop-source.html

cat bitop-source.html | pup 'a attr{href}' | grep -e LuaBitOp\- | awk '{print "https://bitop.luajit.org/"$1}' > bitop-source.txt

wget -c -i bitop-source.txt
