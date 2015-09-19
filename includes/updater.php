<?php

define('THEMES_DIR',	ABSPATH.'wp-content/themes/');
define('THEME_DIR',		THEMES_DIR.'material-for-coders');
define('THEME_DIR_TMP', THEMES_DIR.'material-for-coders-master');
define('THEME_ZIP',		THEMES_DIR.'material-for-coders-master.zip');
define('THEME_ZIP_URL',	'https://github.com/emmgfx/material-for-coders/archive/master.zip');

function get_content_from_github($url) {
	try {
	    $ch = curl_init();

	    if (FALSE === $ch)
	        throw new Exception('failed to initialize');

	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, "https://github.com/emmgfx/");

	    $content = json_decode(curl_exec($ch), true);

		return $content;

	    if (FALSE === $content)
	        throw new Exception(curl_error($ch), curl_errno($ch));

	} catch(Exception $e) {
	    trigger_error(sprintf('Curl failed with error #%d: %s', $e->getCode(), $e->getMessage()), E_USER_ERROR);
	}
}

function download_latest(){

	$rh = fopen(THEME_ZIP_URL, 'rb');
    $wh = fopen(THEME_ZIP, 'w+b');
    if (!$rh || !$wh) {
        return false;
    }

    while (!feof($rh)) {
        if (fwrite($wh, fread($rh, 4096)) === FALSE) {
            return false;
        }
        echo ' ';
        flush();
    }

    fclose($rh);
    fclose($wh);

    return true;

}

function unpack_downloaded(){

	$zip = new ZipArchive;
	$res = $zip->open(THEME_ZIP);
	if ($res === TRUE) {
	  $zip->extractTo(THEMES_DIR);
	  $zip->close();
	  return true;
	} else {
	  return false;
	}
}

function install_unpacked(){
	deltree(THEME_DIR);
	return rename(THEME_DIR_TMP, THEME_DIR);
}

function delTree($dir) {
	$files = array_diff(scandir($dir), array('.','..'));
	foreach ($files as $file) {
		(is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
	}
	return rmdir($dir);
}

?>
