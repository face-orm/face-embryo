#!/bin/bash




set -e

#CHECK COMMAND CALL
if [ $# -ne 1 ]; then
  echo "Usage: `basename $0` <tag>"
  exit 65
fi

# CHECK TAG FORMAT
php -r "if(preg_match('/^\d+\.\d+\.\d+(?:-([0-9A-Za-z-]+(?:\.[0-9A-Za-z-]+)*))?(?:\+([0-9A-Za-z-]+(?:\.[0-9A-Za-z-]+)*))?\$/',\$argv[1])) exit(0) ;else{ echo 'format of version tag is not invalid' . PHP_EOL ; exit(1);}" $1


#CHECK TAG FORMAT
if ! [[ $1 =~ ^[0-9]\.[0-9]\.[0-9]$ ]]; then

    echo "Tag is not well formated. It should be x.x.x (e.g: 1.1.2)." 
    echo " Aborting..."
    exit 65
fi

# CHECK MASTER BRANCH
CURRENT_BRANCH=$(git rev-parse --abbrev-ref HEAD)
if [[ "$CURRENT_BRANCH" != "master" ]]; then
  echo "You have to be on master branch currently on $CURRENT_BRANCH . Aborting"
  exit 65
fi


# CHECK THE box.json file
if [ ! -f box.json ]; then
    echo "The current directory is not buildable. Go to the root of the application before running the script."
fi

# CHECK jsawk COMMAND
command -v jsawk >/dev/null 2>&1 || { echo "Error : Command jsawk is not installed on the system"; echo "See : https://github.com/micha/jsawk "; echo  "Exiting..." >&2; exit 65; }

# CHECK js COMMAND
command -v js >/dev/null 2>&1 || { echo "Error : Command js is not installed on the system"; echo "Should be fixed by installing spidermonkey "; echo  "Exiting..." >&2; exit 65; }


# CHECK box COMMAND
command -v box >/dev/null 2>&1 || { echo "Error : Command box is not installed on the system"; echo "See : https://github.com/box-project/box2 "; echo  "Exiting..." >&2; exit 65; }

# CHECK python COMMAND
command -v python >/dev/null 2>&1 || { echo "Error : Command python is not installed on the system"; echo  "Exiting..." >&2; exit 65; }


# CHECK THAT WE CAN CHANGE BRANCH
git checkout gh-pages
git checkout --quiet master


TAG=$1

# Tag master
git tag -a ${TAG} -m 'version${TAG}'

# Build phar
box build



# GO TO gh-pages
git checkout gh-pages

# MOVE THE BUILT FILE
mv embryo.phar build/embryo-${TAG}.phar
git add build/embryo-${TAG}.phar

SHA1=$(sha1sum build/embryo-${TAG}.phar | sed 's/ .*//')

JSON='name:"embryo.phar"'
JSON="${JSON},sha1:\"${SHA1}\""
JSON="${JSON},url:\"http://laemons.github.io/face-embryo/build/embryo-${TAG}.phar\""
JSON="${JSON},version:\"${TAG}\""


cat manifest.json | jsawk -a "this.push({${JSON}})" | python -mjson.tool > manifest.json.tmp
mv manifest.json.tmp manifest.json
git add manifest.json

git commit -m "Build version ${TAG}"

git checkout master

echo "New version created. Now you should run:"
echo "git push"
echo "git push --tags"