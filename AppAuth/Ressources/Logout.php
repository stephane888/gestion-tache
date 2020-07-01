<?php
use Stephane888\Authen\Auth\Connect;

$Connect = new Connect();
$Connect->logout();
/**
 * Redirect to home.
 */
// header("Location: http://mynutribe.kksa/");
header("Location: /");
exit();
