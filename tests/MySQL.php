<?php
include "../Resource/MySQL.php";

$mysql = MySQL::connect();
$result = $mysql->query("SELECT 1");
while ($row = $result->fetchAssoc()) {
	print_r($row);
}
