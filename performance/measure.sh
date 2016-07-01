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
ab -g $name.perf -k -l -n 2000. -c 50 http://nevv.herokuapp.com/  2>&1 > /dev/null
echo "$name.perf" | gnuplot ../plot.p && mv sequence.jpg $name.jpg

echo "Measurement $name successful"