#!/bin/bash

# This script needs zip binary: apt-get install zip
#
# To resolve dependencies of hashcat execute ./tools/deps.sh from hashcat repo

PATH_ME="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

PATH_REPO="$PATH_ME/repo"
PATH_SERVER="$PATH_ME/cracker"

# Loop through vendors
for vendor_name in hashcat oclHashcat cudaHashcat
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
	if [ "$vendor_name" == "hashcat" ]; then
		make
	fi

	# Remove current vendor from server
	rm -f -R "$PATH_VENDOR_SERVER/"

	# Loop through os-arch
	if [ "$vendor_name" == "hashcat" ]; then
		os_arch_list="cpu_linux_64.bin cpu_linux_32.bin cpu_win_64.exe cpu_win_32.exe cpu_mac_64.app cpu_mac_32.app"
	elif [ "$vendor_name" == "oclHashcat" ]; then
		os_arch_list="gpu_linux_64_amd.bin gpu_linux_32_amd.bin gpu_win_64_amd.exe gpu_win_32_amd.exe gpu_mac_64_amd.app gpu_mac_32_amd.app"
	elif [ "$vendor_name" == "cudaHashcat" ]; then
		os_arch_list="gpu_linux_64_nv.bin gpu_linux_32_nv.bin gpu_win_64_nv.exe gpu_win_32_nv.exe gpu_mac_64_nv.app gpu_mac_32_nv.app"
	else
		echo "Unknown error!!!"
		exit
	fi

	for os_arch in $os_arch_list
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
			echo "Warning, vendor not found: $PATH_VENDOR_REPO/bin/$os_arch"
		fi
	done
done