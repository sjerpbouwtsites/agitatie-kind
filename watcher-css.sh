inotifywait -m -e modify style.css  | while read file; 
do timestamp=$(date +%d-%m-%Y_%H-%M-%S); echo $timestamp > watcher.log
done;
