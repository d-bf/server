#!/bin/bash

# This script needs zip binary: apt-get install zip
#
# To resolve dependencies of hashcat execute ./tools/deps.sh from hashcat repo

PATH_ME="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

PATH_REPO="$PATH_ME/repo"
PATH_SERVER="$PATH_ME/cracker"

# Clone or update dbf-vendor
if [ -d "$PATH_REPO/generator-general-gpu/.git" ]; then
	cd "$PATH_REPO/generator-general-gpu"
	git pull origin
else
	git clone "https://github.com/dbf-vendor/generator-general-gpu" "-b" "bin" "$PATH_REPO/generator-general-gpu"
	cd "$PATH_REPO/generator-general-gpu"
fi

# Loop through vendors
for vendor_name in hashcat oclHashcat cudaHashcat
do
	PATH_VENDOR_REPO="$PATH_REPO/vendor-cracker-$vendor_name"
	PATH_VENDOR_SERVER="$PATH_SERVER/$vendor_name"
	PATH_DEP_ZIP="$PATH_VENDOR_REPO/bin/dep.zip"

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

	# Remove dep.zip file
	rm -f "$PATH_DEP_ZIP"

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

			# Check dep.zip and create it if needed
			if [ ! -f "$PATH_DEP_ZIP" ]; then
				cd "$PATH_VENDOR_REPO/bin/dep/"
				zip -r "$PATH_DEP_ZIP" "."
			fi

			# Compress vendor
			cp -f "$PATH_DEP_ZIP" "$PATH_VENDOR_REPO/bin/$os_arch.zip"

			if [ ${os_arch%%_*} == "gpu" ]; then # GPU
				cp -af "$PATH_VENDOR_REPO/bin/$os_arch" "$PATH_VENDOR_REPO/bin/hashcat.${os_arch##*.}"
				zip -jg "$PATH_VENDOR_REPO/bin/$os_arch.zip" "$PATH_VENDOR_REPO/bin/hashcat.${os_arch##*.}"

				temp=${os_arch#gpu_}
				osarch=${temp%%_*}
				temp=${temp#*_}
				osarch="$osarch"_${temp%%_*}

				if [ -f "$PATH_REPO/generator-general-gpu/$osarch" ]; then
					cp -af "$PATH_REPO/generator-general-gpu/$osarch" "$PATH_VENDOR_REPO/bin/cracker.${os_arch##*.}"
					zip -jg "$PATH_VENDOR_REPO/bin/$os_arch.zip" "$PATH_VENDOR_REPO/bin/cracker.${os_arch##*.}"
				fi
			else # CPU
				cp -af "$PATH_VENDOR_REPO/bin/$os_arch" "$PATH_VENDOR_REPO/bin/cracker.${os_arch##*.}"
				zip -jg "$PATH_VENDOR_REPO/bin/$os_arch.zip" "$PATH_VENDOR_REPO/bin/cracker.${os_arch##*.}"
			fi

			# Move to server
			mv "$PATH_VENDOR_REPO/bin/$os_arch.zip" "$PATH_VENDOR_SERVER/${os_arch%.*}" # Remove file extension
		else
			echo "Warning, vendor not found: $PATH_VENDOR_REPO/bin/$os_arch"
		fi
	done
done

# Remove temp files
rm -f "$PATH_VENDOR_REPO"/bin/hashcat.*
rm -f "$PATH_VENDOR_REPO"/bin/cracker.*

# Remove dep.zip file
rm -f "$PATH_DEP_ZIP"