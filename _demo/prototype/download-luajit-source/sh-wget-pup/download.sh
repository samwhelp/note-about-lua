#!/usr/bin/env bash

mkdir -p download

cd download

#wget -c --html-extension 'https://luajit.org/download.html'
wget -c 'https://luajit.org/download.html' -O luajit-source.html

cat luajit-source.html | pup 'a attr{href}' | grep -e LuaJIT | awk '{print "https://luajit.org/"$1}' > luajit-source.txt

wget -c -i luajit-source.txt
