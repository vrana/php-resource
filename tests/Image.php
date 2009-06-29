<?php
include "../Resource/bundled/Image.php";

$image = Image::createFromJpeg("vrana.jpg");
$image->jpeg("x.jpg");
