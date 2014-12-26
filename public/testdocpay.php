<?php

require_once('../config/config.php');

$config = getConfig();

$amount = "10.23";
$amountcurr = "RUB";
$currency = "MBC";
$number = "5412";
$description = urlencode("Тестовая оплата на $amount $amountcurr");
$trtype = "1";
$account = "ACC0002";

$signature = "$amount:$amountcurr:$currency:$number:$description:";
$signature .= "$trtype:$account:0baff10f-e9fd-722b-4dd4-33e70ddeab42:ffffdddd9573eeee";
$signature = strtoupper(md5($signature));

?>
<html>
<head>
<title>e-POS.ru: платёжный шлюз</title>

</head>

<body onload="setTimeout('document.go.submit()', 3000);">
<center>Пожалуйста, подождите. Осуществляется переключение на оплату...</center>
<form name=go action="<?php echo $config['epos_start_url'];?>?XDEBUG_SESSION_START=18377" method="POST">
	<input type="hidden" name="amount" value="<?php print $amount?>">
	<input type="hidden" name="amountcurr" value="<?php print $amountcurr?>">
	<input type="hidden" name="currency" value="<?php print $currency?>">
	<input type="hidden" name="number" value="<?php print $number?>">
	<input type="hidden" name="description" value="<?php print $description?>">
	<input type="hidden" name="trtype" value="<?php print $trtype?>">
	<input type="hidden" name="account" value="<?php print $account?>">
	<input type="hidden" name="signature" value="<?php print $signature?>">
</form>
</body>