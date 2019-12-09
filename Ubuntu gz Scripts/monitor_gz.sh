#!/bin/bash
echo 'strace static gz files'
echo 'run `sudo service nginx reload` in a new terminal'
echo 'strace can only trace children created after attached to the master process'

strace -e trace=open -p `pidof nginx | sed -e 's/ /,/g'` 2>&1 | grep .gz
