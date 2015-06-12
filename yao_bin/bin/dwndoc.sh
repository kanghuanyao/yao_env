#!/bin/bash
# download from ck101.

Start="1"
End="129"
BookID="2226565"

Agent="Mozilla/5.0 (iPhone; U; CPU iPhone OS 3_0 like Mac OS X; en-us) AppleWebKit/528.18 (KHTML, like Gecko) Version/4.0 Mobile/7A341 Safari/528.16"

TMP_HTML="tmp.html"

Session=1

for (( i=$Start; i<=$End; i=i+1 ))
do
	url="http://ck101.com/thread-$BookID-$i-1.html"
	TXT_filename="$BookID-$Session.txt"

	echo "url=$url"
	echo "TXT_filename=$TXT_filename"

	wget -q --no-http-keep-alive -U "$Agent" -O $TMP_HTML $url
	python html2text.py --ignore-emphasis --ignore-links --ignore-images $TMP_HTML | uniq >> $TXT_filename
	
#	sed -e '/<script/,/<\/script>/d' -e 's/<[^>]\+>/ /g' -e 's/&nbsp;//g' -e 's/^[ \t]*//g' -e 's/[ \t]*$//g' $TMP_HTML | uniq >> $TXT_filename
	rm $TMP_HTML

	sleep 0.5s

	if [ $(expr $i % 50) == "0" ] ; then
		Session=$(expr $Session + 1)
	fi
done


