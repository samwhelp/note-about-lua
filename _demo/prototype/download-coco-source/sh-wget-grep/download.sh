#!/usr/bin/env bash

mkdir -p download

cd download

wget -c 'https://coco.luajit.org/download.html' -O raw.html

xmllint --html --format raw.html > coco-source.html

cat coco-source.html | grep -Po 'href=\".*?\"' | grep -Po '="\K[^"]+' | grep -e LuaCoco\- | awk '{print "https://coco.luajit.org/"$1}' > coco-source.txt

wget -c -i coco-source.txt
