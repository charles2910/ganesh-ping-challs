#!/bin/bash

## declare array of containers
declare -a containers=("A"  "B"  "C"  "D" "S1"  "S2"  "S3" "S4")
declare -a containerPorts=(
    "-p 1330:80" 
    "-p 1331:80" 
    "-p 1332:80"
    "-p 2337:2337"
    "-p 1333:80" 
    "-p 1334:80" 
    "-p 1335:80"
    "-p 80:80 -p 443:443"
    )

## Starting the script
echo "SCRIPT: CREATING DOCKER CONTAINERS"

## now loop through the above array
for i in {0..7}
do
    read -r -p "START CONTAINER IMAGE [${containers[$i]}]? (y/n): " userOption
    if [[ "$userOption" =~ ^([yY][eE][sS]|[yY])$ ]]
    then
        echo "| -- Container [${containers[$i]}]: Starting..."
        sudo docker run -d ${containerPorts[$i]} --rm --name "ganesh-${containers[$i],,}-instance" "ganesh/container-${containers[$i],,}:1.0"
        echo "| -- Container [${containers[$i]}]: Container started!"
    else 
        continue
    fi
done

echo "LISTING CURRENT CONTAINERS:"
sudo docker container ls

## Ending the script
echo "SCRIPT END - DOCKER CONTAINERS RUNNING! X)"