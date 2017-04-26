<?php
include("object/jwt.php");

$token = array();
$token['id'] = "1"; // putting hard coded right now but it can be dynamically from DB.
$token['email'] = "jay@example.com";
define("SECRET_SERVER_KEY", "tnyDML2b");

echo "JWT Token :::: " . encode(SECRET_SERVER_KEY, $token);
echo "\n\n\n\n\n";

$k = "eyJqd3QiOiJqd3QiLCJ0eXBlIjoiSFMyNTYifQ.eyJpZCI6IjEiLCJlbWFpbCI6ImpheUBleGFtcGxlLmNvbSJ9.";
$token = decode($k, SECRET_SERVER_KEY);

var_dump($token->id);
echo "email ::::" . $token->email;

// id :::: 1
// email :::: jay@example.com

?>