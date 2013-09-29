<?php

if(!isset($_POST) || !isset($_POST['name']) || !isset($_POST['code'])) die('invalid parameters');

$name = $_POST['name'];
$code = $_POST['code'];

header("Content-Type: application/octet-stream;");
header("Content-Transfer-Encoding: binary");
header("Content-Length: ". count($code).";");
header("Content-disposition: attachment; filename=$name");

echo $code;