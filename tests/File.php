<?php
include "../Resource/bundled/File.php";

$dir = Dir::open(".");
while ($filename = $dir->read()) {
	if ($filename == basename(__FILE__)) {
		$fp = File::open($filename, "r");
		echo $fp->getS();
	}
}
