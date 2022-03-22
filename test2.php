<?php
ini_set("display_errors", 1);
require "api/v1/inc/loader.php";

$token = new yamws\token();

$n_token = $token->generate_token_user(1, "duck@duck.org", "user");
$d_token = $token->decode_token_user($n_token["jwt"], $n_token["key"], 1);

$h = "hi";
echo "<pre>";
var_dump($n_token, $h, $d_token);
echo "</pre>";


?>