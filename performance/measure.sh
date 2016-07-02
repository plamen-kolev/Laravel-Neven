if [ $# -eq 0 ]; then
    echo "specify measurement name"
    read name
else
    name="$1"
fi

mkdir $name
cd $name

wget http://nevv.herokuapp.com
rm index.html

website="$2"
if[!$website]; then
    # website="http://nevv.herokuapp.com/"
    website="localhost:8000"
fi

ab -g $name.perf -k -l -n 2000. -c 50 $website  2>&1 > /dev/null
echo "$name.perf" | gnuplot ../plot.p && mv sequence.jpg $name.jpg

echo "Measurement $name successful"