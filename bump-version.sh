#!/bin/bash

set -e

#
# Tag & build master branch
#
git checkout master

if [ $# -ne 1 ]; then
  git fetch --tags
  TAG=$(git describe --abbrev=0 --tags)
else
  TAG=$1
  git tag ${TAG}
fi

box build

#
# Copy executable file into GH pages
#
git checkout gh-pages

cp migraine.phar downloads/migraine-${TAG}.phar
git add downloads/migraine-${TAG}.phar

cp migraine.phar downloads/migraine.phar
git add downloads/migraine.phar

git show master:installer.sh > installer
git add installer

SHA1=$(openssl sha1 migraine.phar | egrep -o '[0-9a-f]{40}\b')

JSON='name:"migraine.phar"'
JSON="${JSON},sha1:\"${SHA1}\""
JSON="${JSON},url:\"http://jiabin.github.io/migraine/downloads/migraine-${TAG}.phar\""
JSON="${JSON},version:\"${TAG}\""

if [ -f migraine.phar.pubkey ]; then
    cp migraine.phar.pubkey pubkeys/migraine-${TAG}.phar.pubkeys
    git add pubkeys/migraine-${TAG}.phar.pubkeys
    JSON="${JSON},publicKey:\"http://jiabin.github.io/migraine/pubkeys/migraine-${TAG}.phar.pubkey\""
fi

#
# Update manifest
#
cat manifest.json | jsawk -a "this.push({${JSON}})" | python -mjson.tool > manifest.json.tmp
mv manifest.json.tmp manifest.json
git add manifest.json

git commit -m "Bump version ${TAG}"

#
# Go back to master
#
git checkout master
git push origin gh-pages
git push origin ${TAG} 

echo "Success!"