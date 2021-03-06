#!/bin/bash

# This script needs go and 7z binaris: apt-get install golang p7zip-full
#
# To resolve dependencies of hashcat execute ./tools/deps.sh from hashcat repo

PATH_ME="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

PATH_GO="$PATH_ME/repo/go"
PATH_REPO="$PATH_GO/src/github.com/d-bf"
PATH_DOWNLOAD="$PATH_ME/../public/last/d-bf"
PATH_YII="$PATH_ME/../../yii"

mkdir -p "$PATH_REPO"

# Clone or update dbf
if [ -d "$PATH_REPO/client/.git" ]; then
	cd "$PATH_REPO/client"
	git pull origin
else
	git clone "https://github.com/d-bf/client.git" "-b" "golang" "$PATH_REPO/client"
fi

cd "$PATH_REPO/client/main/dbf"
export GOPATH="$PATH_GO"
./cross-compile.sh

PATH_BUILD="./dbf_release"

# Compress to download dir
7z a "$PATH_DOWNLOAD/linux_32.7z"	"$PATH_BUILD/linux_32/dbf"
7z a "$PATH_DOWNLOAD/linux_64.7z"	"$PATH_BUILD/linux_64/dbf"

7z a "$PATH_DOWNLOAD/windows_32.7z"	"$PATH_BUILD/win_32/dbf.exe"
7z a "$PATH_DOWNLOAD/windows_64.7z"	"$PATH_BUILD/win_64/dbf.exe"

7z a "$PATH_DOWNLOAD/mac_32.7z"		"$PATH_BUILD/mac_32/dbf"
7z a "$PATH_DOWNLOAD/mac_64.7z"		"$PATH_BUILD/mac_64/dbf"

# Sync download table
$PATH_YII files/sync