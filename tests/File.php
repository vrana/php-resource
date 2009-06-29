<?php
include "../Resource/bundled/File.php";

$fp = File::open(__FILE__, "r");
echo $fp->getS();
