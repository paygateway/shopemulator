<?php
require_once('../config/config.php');

$mode = $_POST["opertype"];

$account     = $_POST["account"];
$transID     = $_POST["transID"];
$signature   = $_POST["signature"];

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
    $testsig .= "$number:$description:$trtype:$account:$transID";
    break;
	case "block":
		$amount      = $_POST["amount"];
    $amountcurr  = $_POST["amountcurr"];
    $currency    = $_POST["currency"];
    $number      = $_POST["number"];
    $description = urlencode(urldecode($_POST["description"]));
    $trtype      = $_POST["trtype"];

    $testsig  = "$mode:$amount:$amountcurr:$currency:";
    $testsig .= "$number:$description:$trtype:$account:$transID";
		break;
  case "terminate":
    $amountterminate = $_POST["amountterminate"];

    $testsig  = "$mode:$amountterminate:$transID:$account";
    break;

  case "reversal":
    $amountreversal      = $_POST["amountreversal"];

    $testsig  = "$mode:$amountreversal:$transID:$account";
    break;
	case "unblock":
		$testsig  = "$mode:$transID:$account";
		break;
}

$testsig .= ':'.$config['key1'].':'.$config['key2'];
$testsig  = strtoupper(md5($testsig));

if ($signature == $testsig) {
  //print "OK";
	print $transID;
  exit(-1);
}

print "No, thanks";
