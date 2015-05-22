<?php
require_once('../config/config.php');
require_once('../classes/Exchanger.php');


$config = getConfig();

$hashing_method = $config['hashing_method'];

$amount       = $_POST["amount"];
$amountcurr   = $_POST["amountcurr"];
$number       = $_POST["number"];
$payamount    = $_POST["payamount"];
$currency     = $_POST["currency"];
$description  = urlencode(urldecode($_POST['description']));
$trtype       = $_POST['trtype'];
$percentplus  = $_POST["percentplus"];
$percentminus = $_POST["percentminus"];
$signature    = $_POST["signature"];
$account = $config['account'];
$backURL = $_POST['backURL'];
$transID = $_POST['transID'];

$testsig  = "$amount:$amountcurr:$currency:$number:$description:$trtype:$payamount:";
$testsig .= "$percentplus:$percentminus:$account";

if(!empty($backURL)) {
  $testsig .= ":$backURL";
}
$testsig .= ":$transID:{$_POST['datetime']}:";

$testsig .= $config['key1'].':'.$config['key2'];

$hashed = ($hashing_method=='md5') ? $hashing_method($testsig) : $hashing_method('sha256',$testsig, $config['key1'].$config['key2']);

$testsignature  = strtoupper($hashed);

//$resp = Exchanger::operate('unblock',$_POST, $config);
if ($signature==$testsignature) {
  //Exchanger::operate($trtype==2 ?'unblock':'check',$_POST, $config);
  Exchanger::operate('check',$_POST, $config);
  // Цифровая подпись корректна, счёт оплачен,
  // произвести изменение статуса заказа
  /*if($resp['status']=='OK'||$resp['status']=='authorise') {

  }*/
  print "OK";
  exit(-1);

}

print "No, thanks";