<?php

require_once('../config/config.php');

$config = getConfig();

$data = $_POST;
$description = urlencode($data['description']);
$data['signature'] = "{$data['amount']}:{$data['amountcurr']}:{$data['currency']}:";
$data['signature'] .= "{$data['number']}:{$description}:{$data['trtype']}:{$data['account']}";

if(!empty($data['backURL'])) {
	$data['signature'] .= ":{$data['backURL']}";
}
$data['signature'] .= ":{$data['key1']}:{$data['key2']}";
$data['signature'] = strtoupper(md5($data['signature']));

?>
<html>
<head>
<title>e-POS.ru: платёжный шлюз</title>

</head>

<body onload="setTimeout('document.go.submit()', 3000);">
<center>Пожалуйста, подождите. Осуществляется переключение на оплату...</center>
<form name=go action="<?php echo $config['epos_start_url'];?>" method="POST">
	<input type="hidden" name="amount" value="<?php echo $_POST['amount'];?>">
	<input type="hidden" name="amountcurr" value="<?php echo $_POST['amountcurr'];?>">
	<input type="hidden" name="number" value="<?php echo $_POST['number'];?>">
	<input type="hidden" name="description" value="<?php echo $description;?>">
	<input type=hidden name="trtype" value="<?php echo $_POST['trtype'];?>">
	<input type=hidden name="currency" value="<?php echo $_POST['currency'];?>">
	<input type=hidden name="account" value="<?php echo $_POST['account'];?>">
	<input type=hidden name="signature" value="<?php echo $data['signature'];?>">
	<input type=hidden name="frontend_uri" value="<?php echo $config['frontend_uri'];?>">
	<input type=hidden name="shop_uri" value="<?php echo $config['shop_uri'];?>">
	<input type=hidden name="backURL" value="<?php echo $_POST['backURL'];?>">
</form>
</body>