#!/bin/bash


if [[ $1 ]]; then
    if [[ -e /tmp/aw_search ]]; then
        rm /tmp/aw_search
    fi

    grep -lr "$1" /usr/share/doc/arch-wiki/html/en/* | while read line; do
        number=$(grep -c $1 $line | cut -d : -f 2)
        echo "$number $line" >> /tmp/aw_search;
    done
    
    sort -nr /tmp/aw_search | cut -d ' ' -f 2 > /tmp/aw_results 
    mv /tmp/aw_results /tmp/aw_search
    words=$(wc -l /tmp/aw_search | cut -d ' ' -f 1) 

    if [[ words -gt 30 ]]; then
        echo "$words results, showing first 30"
        head -n 30 /tmp/aw_search | nl;
    else
        nl < /tmp/aw_search
    fi
        num=0;
        read -p "Enter number: " num
    w3m $(sed -n $num\p /tmp/aw_search)
else
    read -p "Search arch wiki for: " search
    aw $search
fi
