<?php

function getSystemDirectorySeparator() {

	$directory_separator = "/";

	$pwd = getcwd();
	if (preg_match("/:/", $pwd)) {
		$directory_separator = "\\";
	}
	return $directory_separator;
}

function launchUpgradeByCurl($rootURL)
{
	$myCurl = curl_init();
	curl_setopt($myCurl, CURLOPT_URL, $rootURL);
	curl_setopt($myCurl, CURLOPT_HEADER, 0);
	curl_setopt($myCurl, CURLOPT_RETURNTRANSFER, 1);

	$myData = curl_exec($myCurl);
	if(!curl_errno($myCurl)){
		$info = curl_getinfo($myCurl);
	} else {
		print "Curl error: ". curl_error($myCurl);
		exit(1);
	}
	
	curl_close($myCurl);
}

function delete_directory($dir)
{
	if (!preg_match("/\/$/", $dir)) {
		$dir .= '/';
	}
	if ($handle = @opendir($dir)) {
		while (strlen($file = readdir($handle))) {
			if ($file != '.' && $file != '..') {
				if(is_dir($dir.$file)) {
					if(!@rmdir($dir.$file)) {
						delete_directory($dir.$file.'/');
					}
				} else {
					@unlink($dir.$file);
				}
			}
		}
	}
	@closedir($handle);
	@rmdir($dir);
}



?>
