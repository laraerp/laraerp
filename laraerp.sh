#!/bin/bash

if [ -z "$1" ]
  then
    LINK="http://github.com"
  else
    LINK="http://$1@github.com"
fi

echo "Listando conteudo de vendor/laraerp"

for i in `ls ./vendor/laraerp`
do
	echo "Removendo ".$i."..."
	rm -rf ./vendor/laraerp/$i

	echo "Clonando ".$i."..."
	git clone $LINK/laraerp/$i.git ./vendor/laraerp/$i
done
