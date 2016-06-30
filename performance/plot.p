# Let's output to a jpeg file
set terminal jpeg size 1200,720
# This sets the aspect ratio of the graph
set size 1, 1
# The file we'll write to
set output "sequence.jpg"
# The graph title
set title "Benchmark testing"
# Where to place the legend/key
set key left top
# Draw gridlines oriented on the y axis
set grid y
# Label the x-axis
set xlabel 'requests'
# Label the y-axis
set ylabel "response time (ms)"
# Tell gnuplot to use tabs as the delimiter instead of spaces (default)
set datafile separator '\t'
# Plot the data
fname = system("read filename; echo $filename")
plot fname every ::6 using 5 title 'response time' with lines
exit