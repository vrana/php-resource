<?php
include "../Resource/Image.php";

$image = Image::createFromJpeg("vrana.jpg");
$image->jpeg("x.jpg");
