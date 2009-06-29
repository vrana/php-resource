<?php
include "../Resource/bundled/MySQL.php";

$mysql = MySQL::connect();
$mysql->initializing = true;
$mysql->selectDb("test");
$mysql->setCharset("utf8");
$mysql->initializing = false;
$result = $mysql->query("SELECT 1");
while ($row = $result->fetchAssoc()) {
	print_r($row);
}
