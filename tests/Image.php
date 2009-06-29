<?php
include "../Resource/extensions/Image.php";

$image = Image::createFromJpeg("vrana.jpg");
$image->jpeg("x.jpg");
