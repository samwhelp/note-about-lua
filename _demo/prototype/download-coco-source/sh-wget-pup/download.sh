#!/usr/bin/env bash

mkdir -p download

cd download

#wget -c --html-extension 'https://coco.luajit.org/download.html'
wget -c 'https://coco.luajit.org/download.html' -O coco-source.html

cat coco-source.html | pup 'a attr{href}' | grep -e LuaCoco\- | awk '{print "https://coco.luajit.org/"$1}' > coco-source.txt

wget -c -i coco-source.txt
