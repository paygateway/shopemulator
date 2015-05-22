<?php
    require_once "PHPUtils/Configuration.php";       
    
    $pk = 'id';
    
    $ID = isset($_REQUEST[ $pk ]) ? $_REQUEST[ $pk ]: '';
    $paymentid = isset($_REQUEST['paymentid']) ? $_REQUEST['paymentid']: '';
    $amount = isset($_REQUEST['amount']) ? $_REQUEST['amount']: '';
    $action = isset($_REQUEST['action']) ? $_REQUEST['action']: '';
    
    $Config = new Configuration('db.lst'); 
    $paymentid      = $Config->get($ID . '.paymentid');
    $trackid      = $Config->get($ID . '.trackid');
    $tranid       = $Config->get($ID . '.tranid');    
    $result       = $Config->get($ID . '.result');
	$error        = $Config->get($ID . '.error');
	$errortext    = $Config->get($ID . '.errortext');		
?>
<html>
<head>
<title>Simple Checkout Demo</title>
	<style type="text/css">
	<?php include "styles/style.css" ?>
	</style>
</head>
<body>
<center>
<table width="80%" style="border: 1px solid darkred;">
	<tr>
		<th><h1><font color="darkred">Your </font>Merchant Logo</h1></th>
	</tr>
</table>
<form name="transactionForm" action="PaymentTran.php" method="POST" >
<table width="80%">
	
    <tr>
		<th colspan="2">Shopping Cart Checkout</th>
	</tr>
	
    <tr>
		<th colspan="2"><hr/></th>
	</tr>
		
     <tr>
		<td align="right">Action:</td>
		<td><input type="text" name="action" size="10" value="<?php echo $action; ?>"/></td>
	</tr>
    
    <tr>
		<td align="right">Amount:</td>
		<td><input type="text" name="amount" size="10" value="<?php echo $amount; ?>"/></td>
	</tr>
    
    <tr>
		<td align="right">PaymentID:</td>
		<td><input type="text" name="paymentid" size="50" value="<?php echo $paymentid; ?>"/></td>
	</tr>
    
    <tr>
		<td align="right">TrackID:</td>
		<td><input type="text" name="trackid" size="50" value="<?php echo $trackid; ?>"/></td>
	</tr>
    
    <tr>
		<td align="right">TranID:</td>
		<td><input type="text" name="tranid" size="50" value="<?php echo $tranid; ?>"/></td>
	</tr>
   
	
	<tr>
		<th colspan="2">&nbsp;</th>
	</tr>
    
	<tr>
		<td colspan="2">
		<input type="button" name="back" value="Return to Index" onClick="location.href='index.php'" class="checkoutButton">
		<input type="submit" name="proceed" value="Proceed to Checkout" class="checkoutButton">
		</td>
	</tr>
    
</table>
</form>
</center>
</body>
</html>
