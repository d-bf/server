#!/bin/bash

PATH_ME="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

PATH_REPO="$PATH_ME/repo"
PATH_BASE="$PATH_ME/generator"

PATH_GENERATOR="$PATH_REPO/vendor-generator-general"
if [ -d "$PATH_GENERATOR/.git" ]; then
	cd "$PATH_GENERATOR"
	git pull origin
else
	git clone https://github.com/d-bf/vendor-generator-general "$PATH_GENERATOR"
	cd "$PATH_GENERATOR"
fi

make

rm -R "$PATH_BASE/general/*"

for os_arch in cpu_linux_64.bin cpu_linux_32.bin cpu_win_64.exe cpu_win_32.exe cpu_mac_64.app cpu_mac_32.app
do
	if [ -f "$PATH_GENERATOR/bin/$os_arch" ]; then
		if [ ! -d "$PATH_BASE/general" ]; then
			mkdir -p "$PATH_BASE/general"
		fi

		zip -jr "$PATH_BASE/general/$os_arch.zip" "$PATH_GENERATOR/bin/$os_arch"
		mv "$PATH_BASE/general/$os_arch.zip" "$PATH_BASE/general/${os_arch%.*}"
	else
		echo "Missing"
	fi
done