#!/bin/bash

## declare array of containers
declare -a containers=("A"  "B"  "C"  "S1"  "S2"  "S3")
declare -a containerPorts=("1330" "1331" "1332" "1333" "1334" "1335")

## Starting the script
echo "SCRIPT: CREATING DOCKER CONTAINERS"

## now loop through the above array
for i in {0..3}
do
    read -r -p "START CONTAINER IMAGE [${containers[$i]}]? (y/n): " userOption
    if [[ "$userOption" =~ ^([yY][eE][sS]|[yY])$ ]]
    then
        echo "| -- Container [${containers[$i]}]: Starting..."
        sudo docker run -d -p "${containerPorts[$i]}:80" --rm --name "ganesh-${containers[$i],,}-instance" "ganesh/container-${containers[$i],,}:1.0"
        echo "| -- Container [${containers[$i]}]: Container started!"
    else 
        continue
    fi
done

echo "LISTING CURRENT CONTAINERS:"
sudo docker container ls

## Ending the script
echo "SCRIPT END - DOCKER CONTAINERS RUNNING! X)"