#!/bin/bash

# This script needs zip binary: apt-get install zip
#
# To resolve dependencies of hashcat execute ./tools/deps.sh from hashcat repo

PATH_ME="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

PATH_REPO="$PATH_ME/repo"
PATH_SERVER="$PATH_ME/cracker"

# Loop through vendors
for vendor_name in hashcat
do
	PATH_VENDOR_REPO="$PATH_REPO/vendor-cracker-$vendor_name"
	PATH_VENDOR_SERVER="$PATH_SERVER/$vendor_name"

	# Clone or update vendor
	if [ -d "$PATH_VENDOR_REPO/.git" ]; then
		cd "$PATH_VENDOR_REPO"
		git pull origin
	else
		git clone "https://github.com/d-bf/vendor-cracker-$vendor_name" "$PATH_VENDOR_REPO"
		cd "$PATH_VENDOR_REPO"
	fi

	# Make vendor file(s) in repo
	make

	# Remove current vendor from server
	rm -f -R "$PATH_VENDOR_SERVER/"

	# Loop through os-arch
	for os_arch in cpu_linux_64.bin cpu_linux_32.bin cpu_win_64.exe cpu_win_32.exe cpu_mac_64.app cpu_mac_32.app
	do
		# Check if the os-arch exists in repo
		if [ -f "$PATH_VENDOR_REPO/bin/$os_arch" ]; then
			mkdir -p "$PATH_VENDOR_SERVER"

			# Compress vendor from repo to server
			cp -a "$PATH_VENDOR_REPO/bin/$os_arch" "$PATH_VENDOR_REPO/bin/dep/"
			cd "$PATH_VENDOR_REPO/bin/dep/"
			zip -r "$PATH_VENDOR_SERVER/$os_arch.zip" "."
			rm -f "$PATH_VENDOR_REPO/bin/dep/$os_arch"

			# Remove file extension
			mv "$PATH_VENDOR_SERVER/$os_arch.zip" "$PATH_VENDOR_SERVER/${os_arch%.*}"
		else
			echo "Error, vendor not found: $PATH_VENDOR_REPO/bin/$os_arch"
		fi
	done
done