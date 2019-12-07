#!/bin/bash
strace -e trace=open -p `pidof nginx | sed -e 's/ /,/g'` 2>&1 | grep .gz
