#!/bin/bash

# The following packages are needed for cross compile. (Tested on debian amd64)
#
# apt-get install git make gcc libc6-dev libc6-dev-i386 mingw-w64 zip
#
# Mac OS X (http://powdertoy.co.uk/Wiki/W/Compiling_for_Mac_on_Linux.html)
# Download and install the following files from: https://launchpad.net/~flosoft/+archive/ubuntu/cross-apple/+packages
#	ccache-lipo
#	apple-x86-odcctools
#	apple-uni-sdk-10.5 (OR apple-uni-sdk-10.6 And then: ln -s /usr/lib/apple/SDKs/MacOSX10.6.sdk /usr/lib/apple/SDKs/MacOSX10.5.sdk)
#	apple-x86-gcc
#	apple-uni-framework-sdl

PATH_ME="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

PATH_REPO="$PATH_ME/repo"
PATH_SERVER="$PATH_ME/generator"

# Loop through vendors
for vendor_name in general markov
do
	PATH_VENDOR_REPO="$PATH_REPO/vendor-generator-$vendor_name"
	PATH_VENDOR_SERVER="$PATH_SERVER/$vendor_name"

	# Clone or update vendor
	if [ -d "$PATH_VENDOR_REPO/.git" ]; then
		cd "$PATH_VENDOR_REPO"
		git pull origin
	else
		git clone "https://github.com/d-bf/vendor-generator-$vendor_name" "$PATH_VENDOR_REPO"
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
			if [ "$vendor_name" == "markov" ]; then
				zip -jr "$PATH_VENDOR_SERVER/$os_arch.zip" "$PATH_VENDOR_REPO/bin/$os_arch" "$PATH_VENDOR_REPO/dep-gen"
			else
				zip -jr "$PATH_VENDOR_SERVER/$os_arch.zip" "$PATH_VENDOR_REPO/bin/$os_arch"
			fi

			# Remove file extension
			mv "$PATH_VENDOR_SERVER/$os_arch.zip" "$PATH_VENDOR_SERVER/${os_arch%.*}"
		else
			echo "Error, vendor not found: $PATH_VENDOR_REPO/bin/$os_arch"
		fi
	done
done