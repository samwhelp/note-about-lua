#!/usr/bin/env bash

mkdir -p download

cd download

wget -c 'https://bitop.luajit.org/download.html' -O raw.html

xmllint --html --format raw.html > bitop-source.html

cat bitop-source.html | grep -Po 'href=\".*?\"' | grep -Po '="\K[^"]+' | grep -e LuaBitOp\- | awk '{print "https://bitop.luajit.org/"$1}' > bitop-source.txt

wget -c -i bitop-source.txt
