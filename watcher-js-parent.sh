inotifywait -m -e modify ../agitatie/resources/build/js/bundel.js  | while read file; 
do timestamp=$(date +%d-%m-%Y_%H-%M-%S); echo $timestamp > watcher.log
done;
