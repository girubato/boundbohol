#run the following commands
find -name "*.php" -exec sed -i "s/\/wp-content/\/content/g" {} \;
find -name "*.php" -exec sed -i "s/wp-content\//content\//g" {} \;
find -name "*.php" -exec sed -i "s/'wp-content'/'content'/g" {} \;
find -name "*.php" -exec sed -i "s/'wp-includes'/'includes'/g" {} \;
find -name "*.php" -exec sed -i "s/wp-includes\//includes\//g" {} \;
find -name "*.php" -exec sed -i "s/wp-admin\//admn\//g" {} \;
find -name "*.php" -exec sed -i "s/'wp-admin'/'admn'/g" {} \;
find -name "*.xml" -exec sed -i "s/wp-admin\//admn\//g" {} \;
find -name "*.php" -exec sed -i "s/'wp-login.php'/'logn.php'/g" {} \;
find -name "*.php" -exec sed -i "s/'wp-login.php\?/'logn.php\?/g" {} \;
find -name "*.php" -exec sed -i "s/\"wp-login.php\?/\"logn.php\?/g" {} \;

mv wp-admin admn;
mv wp-content content;
mv wp-includes includes;
mv wp-login.php logn.php;
mkdir wp-admin;
mkdir wp-content;
mkdir wp-includes;
#line numbers are for wordpress-4.4.2
#edit ./includes/class-wp-editor.php:560: self::$baseurl . '/skins/wordpress/wp-content.css?' . $version
#edit ./includes/functions.php:3973: $path = preg_replace( '#/(admn/.*|logn.php)#i', '', $_SERVER['REQUEST_URI'] );
#<?php
#// Silence is golden.
#vim wp-login.php;
#vim wp-admin/index.php;
#vim wp-content/index.php;
#vim wp-includes/index.php;
