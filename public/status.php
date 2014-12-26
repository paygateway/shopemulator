<?php
require_once('../config/config.php');

$amount       = $_POST["amount"];
$amountcurr   = $_POST["amountcurr"];
$number       = $_POST["number"];
$payamount    = $_POST["payamount"];
$currency     = $_POST["currency"];
$percentplus  = $_POST["percentplus"];
$percentminus = $_POST["percentminus"];
$signature    = $_POST["signature"];
$account = getConfig()['account'];
$transID = $_POST['transID'];

$testsig  = "$amount:$amountcurr:$currency:$number:$payamount:";
$testsig .= "$percentplus:$percentminus:$account:$transID:";
$testsig .= getConfig()['key1'].':'.getConfig()['key2'];
$testsig  = strtoupper(md5($testsig));


if ($signature==$testsig) {
  // Цифровая подпись корректна, счёт оплачен,
  // произвести изменение статуса заказа
  print "OK";
  exit(-1);
}

print "No, thanks";