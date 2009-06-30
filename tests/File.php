<?php
use Resource\File;

include "../Resource/extensions/File.php";

$fp = File::open(__FILE__, "r");
echo $fp->getS();
