#!/bin/bash

# This script creates symlinks from the local GIT repo into your EE install. It also copies some of the extension icons.

dirname=`dirname "$0"`

echo "
You are about to create symlinks for LG Add Sitename
----------------------------------------------------

The symlinks use absolute paths so they are for development purposes only.

The following directories must be writable:

system/extensions
system/modules
system/language
system/lib
themes/cp_global_images
themes/cp_themes/default
themes/site_themes

Enter the full path to your ExpressionEngine install *without a trailing slash* [ENTER]:"
read ee_path
echo "
Enter your ee system folder name [ENTER]:"
read ee_system_folder

# extensions
ln -s "$dirname"/system/extensions/ext.lg_add_sitename.php "$ee_path"/"$ee_system_folder"/extensions/ext.lg_add_sitename.php

# lib
ln -s "$dirname"/system/lib/lg_add_sitename "$ee_path"/"$ee_system_folder"/lib

# language
ln -s "$dirname"/system/language/english/lang.lg_add_sitename.php "$ee_path"/"$ee_system_folder"/language/english/lang.lg_add_sitename.php