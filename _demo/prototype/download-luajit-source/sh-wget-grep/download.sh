#!/usr/bin/env bash

mkdir -p download

cd download

wget -c 'https://luajit.org/download.html' -O raw.html

xmllint --html --format raw.html > luajit-source.html

cat luajit-source.html | grep -Po 'href=\".*?\"' | grep -Po '="\K[^"]+' | grep -e LuaJIT | awk '{print "https://luajit.org/"$1}' > luajit-source.txt

wget -c -i luajit-source.txt
