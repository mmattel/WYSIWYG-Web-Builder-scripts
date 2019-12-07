#!/bin/bash

pathweb='/var/www/<your site>'

gz=$(find $pathweb -name "*.gz" | wc -l)

pu1=$(find $pathweb \( -name "*.css" -o -name "*.js" \) -print0 | xargs -0 du -ksc | tail -1 | awk 'END{print $1}')

pu2=$(find $pathweb/fonts \( -name '*.eot' -or -name '*.otf' -or -name '*.svg' -or -name '*.ttf' -or -name '*.woff' -or -name '*.woff2' \) -print0 | xargs -0 du -ksc | tail -1 | awk 'END {print $1}')

pu3=$(find $pathweb/favicons -name "*.ico" -print0 | xargs -0 du -ksc | tail -1 | awk 'END{print $1}')


pu=$(( pu1 + pu2 + pu3))

# if no gz files are found assign 0 else sum them up
if [[ $gz -eq 0 ]]; then
  gz=0
else
  gz=$(find $pathweb -name "*.gz" -print0 | xargs -0 du -ksc | tail -1 | awk 'END {print $1}')
fi

fr=$(awk -v var1=$gz -v var2=$pu 'BEGIN { print ( var1 / var2 ) }' | awk '{printf "%2.2f",$0}')

echo $fr
