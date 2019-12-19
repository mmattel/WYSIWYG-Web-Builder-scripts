#!/bin/bash

pathweb='/var/www/<your site>'
webuser='your user'
webgroup='your group'

echo
read -p "Create or Delete in dev .gz (c/D)? " -r -e answer
(echo "$answer" | grep -iq "^D") && create_delete="d" || create_delete=$answer

if [[ $create_delete == "d" ]]; then
  echo "Deleting .gz"
  for gz in $(find $pathweb -name '*.gz'); do rm $gz; done
  $(service nginx reload)
  exit
fi

if [[ $create_delete != "c" ]]; then
  echo "No Valid Command"
  exit
fi

echo "Creating .gz"

for css in $(find $pathweb -name '*.css' -or -name '*.js'); do gzip -fkN9 $css; done

for ico in $(find $pathweb/favicons -name '*.ico'); do gzip -fkN9 $ico; done

for font in $(find $pathweb/fonts -name '*.eot' -or -name '*.otf' -or -name '*.svg' -or -name '*.ttf' -or -name '*.ttc' -or -name '*.woff' -or -name '*.woff2'); do gzip -fkN9 $font; done

chown -R $webuser:$webgroup $pathweb/*.gz

exit
