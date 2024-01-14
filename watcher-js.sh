inotifywait -m -e modify resources/build/js/kind-bundel.js  | while read file; 
do timestamp=$(date +%d-%m-%Y_%H-%M-%S); echo $timestamp > watcher.log
done;
