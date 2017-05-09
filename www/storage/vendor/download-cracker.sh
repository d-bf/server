#!/bin/bash

# This script needs 7z binary: apt-get install p7zip-full
#
# To resolve dependencies of hashcat execute ./tools/deps.sh from hashcat repo

PATH_ME="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

PATH_REPO="$PATH_ME/repo"
PATH_TARGET="$PATH_ME/7z"
PATH_DOWNLOAD="$PATH_ME/../public/last"
PATH_YII="$PATH_ME/../../yii"

# Clone or update dbf-vendor
for vendor_name in generator-cpu generator-gpu
do
	if [ -d "$PATH_REPO/$vendor_name/.git" ]; then
		cd "$PATH_REPO/$vendor_name"
		git pull origin
	else
		git clone "https://github.com/dbf-vendor/$vendor_name" "-b" "bin" "$PATH_REPO/$vendor_name"
		cd "$PATH_REPO/$vendor_name"
	fi
done

# Loop through vendors
for vendor_name in hashcat oclHashcat cudaHashcat
do
	PATH_VENDOR_REPO="$PATH_REPO/vendor-cracker-$vendor_name"
	PATH_VENDOR="$PATH_TARGET/cracker/$vendor_name"

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
			rm -f -R "$PATH_TARGET"

			PATH_VENDOR_OS_ARCH="$PATH_VENDOR/${os_arch%.*}" # ${os_arch%.*} removes extension

			mkdir -p "$PATH_VENDOR_OS_ARCH"

			# Copy dep
			cp -af $PATH_VENDOR_REPO/bin/dep/* "$PATH_VENDOR_OS_ARCH/"

			pu=${os_arch%%_*} # cpu | gpu

			cp -af "$PATH_VENDOR_REPO/bin/$os_arch" "$PATH_VENDOR_OS_ARCH/hashcat.${os_arch##*.}"

			# Get platform (linux|windows|mac)
			platform=${os_arch#*_} # Remove *pu_
			platform=${platform%%_*} # Get platform

			# Get bitness (32|64)
			bitness=${os_arch#*_*_} # Remove *pu_platform_
			bitness=${bitness%%[_|.]*} # Get bitness

			osarch="$platform"_"$bitness" # platform_bitness

			if [ -f "$PATH_REPO/generator-$pu/$osarch" ]; then
				cp -af "$PATH_REPO/generator-$pu/$osarch" "$PATH_VENDOR_OS_ARCH/cracker.${os_arch##*.}"
			fi

			# Compress vendor
			cd "$PATH_TARGET"
			7z a archive.7z .

			# Move to public download dir
			if [ -f "$PATH_TARGET/archive.7z" ]; then
				mkdir -p "$PATH_DOWNLOAD/vendor/$vendor_name"
				mv -f "$PATH_TARGET/archive.7z" "$PATH_DOWNLOAD/vendor/$vendor_name/${os_arch%.*}.7z"
			fi
		else
			echo "Warning, vendor not found: $PATH_VENDOR_REPO/bin/$os_arch"
		fi
	done
done

# Remove 7z dir
rm -f -R "$PATH_TARGET"

# Sync download table
$PATH_YII files/sync