#!/bin/bash
echo "Listando conteudo de vendor/laraerp"

for i in `ls ./vendor/laraerp`
do
	echo "Removendo ".$i."..."
	rm -rf ./vendor/laraerp/$i

	echo "Clonando ".$i."..."	
	git clone http://github.com/laraerp/$i.git ./vendor/laraerp/$i
done
