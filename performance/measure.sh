if [ $# -eq 0 ]; then
    echo "specify measurement name"
    read name
else
    name="$1"
fi

mkdir $name
cd $name

#website=http://nevv.herokuapp.com
website=http://neven-body-care.com/

wget $website
rm index.html

ab -g $name.perf -k -l -n 1000. -c 10 $website  2>&1 > /dev/null
echo "$name.perf" | gnuplot ../plot.p && mv sequence.jpg $name.jpg

echo "Measurement $name successful"
