#!/bin/bash

# This script needs zip binary: apt-get install zip
#
# The following packages are needed for cross compile. (Tested on debian amd64)
#
# Linux and windows:
# apt-get install git make gcc libc6-dev libc6-dev-i386 mingw-w64
#
# Mac OS X (http://powdertoy.co.uk/Wiki/W/Compiling_for_Mac_on_Linux.html)
# Download and install the following files from: https://launchpad.net/~flosoft/+archive/ubuntu/cross-apple/+packages
#	ccache-lipo [https://launchpad.net/~flosoft/+archive/ubuntu/cross-apple/+files/ccache-lipo_1.0-0flosoft3_amd64.deb]
#	apple-uni-sdk-10.5 (OR apple-uni-sdk-10.6 And then: ln -s /usr/lib/apple/SDKs/MacOSX10.6.sdk /usr/lib/apple/SDKs/MacOSX10.5.sdk [wget])
#	apple-uni-framework-sdl [https://launchpad.net/~flosoft/+archive/ubuntu/cross-apple/+files/apple-uni-framework-sdl_1.2.14-0flosoft3_amd64.deb]
#	apple-x86-odcctools [https://launchpad.net/~flosoft/+archive/ubuntu/cross-apple/+files/apple-x86-odcctools_758.159-0flosoft11_amd64.deb]
#	apple-x86-gcc [https://launchpad.net/~flosoft/+archive/ubuntu/cross-apple/+files/apple-x86-gcc_4.2.1~5646.1flosoft2_amd64.deb]

PATH_ME="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

PATH_REPO="$PATH_ME/repo"
PATH_SERVER="$PATH_ME/generator"

# Loop through vendors
for vendor_name in general
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

			# Compress vendor
			cp -af "$PATH_VENDOR_REPO/bin/$os_arch" "$PATH_VENDOR_REPO/bin/generator.${os_arch##*.}"
			if [ "$vendor_name" == "markov" ]; then
				zip -jr "$PATH_VENDOR_SERVER/$os_arch.zip" "$PATH_VENDOR_REPO/bin/generator.${os_arch##*.}" "$PATH_VENDOR_REPO/dep-gen"
			else
				zip -jr "$PATH_VENDOR_SERVER/$os_arch.zip" "$PATH_VENDOR_REPO/bin/generator.${os_arch##*.}"
			fi

			if [ -f "$PATH_VENDOR_REPO/info.json" ]; then
				zip -jr "$PATH_VENDOR_SERVER/$os_arch.zip" "$PATH_VENDOR_REPO/info.json"
			fi

			# Move to server
			baseName="${os_arch%.*}"
			mv "$PATH_VENDOR_SERVER/$os_arch.zip" "$PATH_VENDOR_SERVER/$baseName" # Remove file extension

			# Copy for alternative platforms
			#cp -af "$PATH_VENDOR_SERVER/$baseName" "$PATH_VENDOR_SERVER/gpu_${baseName#*_}_amd"
			#cp -af "$PATH_VENDOR_SERVER/$baseName" "$PATH_VENDOR_SERVER/gpu_${baseName#*_}_nv"
		else
			echo "Error, vendor not found: $PATH_VENDOR_REPO/bin/$os_arch"
		fi
	done

	# Remove generator.*
	rm -f "$PATH_VENDOR_REPO"/bin/generator.*
done