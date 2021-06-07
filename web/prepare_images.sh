#!/bin/bash

## declare array of containers
declare -a images=("A"  "B"  "C" "D" "S1"  "S2"  "S3" "S4")

## Starting the script
echo "SCRIPT: CREATING DOCKER IMAGES"

## now loop through the above array
for i in "${images[@]}"
do
    read -r -p "BUILD IMAGE [$i]? (y/n): " userOption
    if [[ "$userOption" =~ ^([yY][eE][sS]|[yY])$ ]]
    then

        ## 1 - Copying the Files to container folder
        echo "| -- IMAGE [$i]: copying challenges files..."
            cp -ru "containers/_default" "containers/$i/default"
            cp -ru "challenges"          "containers/$i/challenges"
        echo "| -- IMAGE [$i]: files moved."

        ## 2 - Building the image (with no-cache)
        echo "| -- IMAGE [$i]: building image..."
            sudo docker build  --no-cache -t "ganesh/container-${i,,}:1.0" "containers/$i/"
        echo "| -- IMAGE [$i]: image build created."

        ## 3 - Remove copy files and folders
        echo "| -- IMAGE [$i]: cleaning challenges..."
            rm -r "containers/$i/default"
            rm -r "containers/$i/challenges"
        echo "| -- IMAGE [$i]: cleaned."

        echo "| -- IMAGE [$i]: build success!"
    else 
        continue
    fi
done

## Ending the script
echo "SCRIPT END - DOCKER IMAGES READ TO USE! :P"
