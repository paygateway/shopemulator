<?php
require_once('../config/config.php');

$mode = $_POST["opertype"];

$account     = $_POST["account"];
$transID     = $_POST["transID"];
$signature   = $_POST["signature"];
$backURL     = $_POST['backURL'];

$datetime    = $_POST['datetime'];

$config = getConfig();

switch($mode) {
  case "pay":
    $amount      = $_POST["amount"];
    $amountcurr  = $_POST["amountcurr"];
    $currency    = $_POST["currency"];
    $number      = $_POST["number"];
    $description = urlencode(urldecode($_POST["description"]));
    $trtype      = $_POST["trtype"];



    $testsig  = "$mode:$amount:$amountcurr:$currency:";
    $testsig .= "$number:$description:$trtype:$account";
	  if(!empty($backURL)) {
		  $testsig .= ":$backURL";
	  }
	  $testsig .= ":$transID";
    $testsig .= ":$datetime";
    break;
  case "terminate":
    $amountterminate = $_POST["amountterminate"];

    $testsig  = "$mode:$amountterminate:$account:$transID:$datetime";
    break;

  case "reversal":
    $amountreversal      = $_POST["amountreversal"];

    $testsig  = "$mode:$amountreversal:$account:$transID:$datetime";
    break;
	case "unblock":
		$testsig  = "$mode:$account:$transID:$datetime";
		break;
}

$testsig .= ':'.$config['key1'].':'.$config['key2'];

$hashing_method = isset($config['hashing_method']) ? $config['hashing_method'] : 'md5';

$hashed = ($hashing_method=='md5') ? $hashing_method($testsig) : $hashing_method('sha256',$testsig, $config['key1'].$config['key2']);

$testsig  = strtoupper($hashed);

if ($signature == $testsig) {
  //print "OK";
	print $transID;
  exit(-1);
}

print "No, thanks";
