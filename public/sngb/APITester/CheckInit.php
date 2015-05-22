<?php
/********************************************************************
 *  @(#)UniversalPluginCheckoutSuccess.php                          *
 *                                                                  *
 *  Copyright (c) 2000 - 2007 by ACI Worldwide Inc.                 *
 *  330 South 108th Avenue, Omaha, Nebraska, 68154, U.S.A.          *
 *  All rights reserved.                                            *
 *                                                                  *
 *  This software is the confidential and proprietary information   *
 *  of ACI Worldwide Inc ("Confidential Information").  You shall   *
 *  not disclose such Confidential Information and shall use it     *
 *  only in accordance with the terms of the license agreement      *
 *  you entered with ACI Worldwide Inc.                             *
 ********************************************************************/

 //
 // The purpose of the UniversalPluginCheckoutSuccess.php is to simulate a
 // typical merchant reciept page and what fields would typically be available
 //

	require_once "PHPUtils/Configuration.php";

	session_start();

	// Response URL: http://omatownsenda/UniversalTester/UniversalPluginCheckoutSuccess.php
	// Message Text: paymentid=748088011572270&result=APPROVED&auth=999999&avr=N&ref=722750360524&tranid=3438383021572270&postdate=0815&trackid=1029309&udf1=&udf2=&udf3=&udf4=&udf5=&responsecode=00&cvv2response=0

	// For PHP Servers.. we need to turn on the session to keep objects in session.
	// Extract the Payment ID from the arguments
    
    // Primary Key
    $pk = 'tranid';    
	$ID  = isset($_REQUEST[ $pk ]) ? $_REQUEST[ $pk ]: '';

	if (strlen($ID) == 0) {
	    $ID = "nonkeyedsection";
	}

	//
	// Now display the reciept data.
	//
	$Config = new Configuration('db.lst');
	$paymentid       = $Config->get($ID . '.paymentid');
    $result       = $Config->get($ID . '.result');
	$error        = $Config->get($ID . '.error');
	$errortext    = $Config->get($ID . '.errortext');
	$ref          = $Config->get($ID . '.ref');
	$responsecode = $Config->get($ID . '.responsecode');
	$cvv2response = $Config->get($ID . '.cvv2response');
	$postdate     = $Config->get($ID . '.postdate');
	$udf1         = $Config->get($ID . '.udf1');
	$udf2         = $Config->get($ID . '.udf2');
	$udf3         = $Config->get($ID . '.udf3');
	$udf4         = $Config->get($ID . '.udf4');
	$udf5         = $Config->get($ID . '.udf5');
	$tranid       = $Config->get($ID . '.tranid');
	$auth         = $Config->get($ID . '.auth');
	$avr          = $Config->get($ID . '.avr');
	$trackid      = $Config->get($ID . '.trackid');

	//
	// PARes is something Special and normally is not retained..
	// Commented out although it is active and will work.
	// $pares        = $_SESSION['PARes'];

	// Now get the stuff we stored in session about the item purchased.
	$quantity = isset($_SESSION['quantity']) ? $_SESSION['quantity']: 1;
	$unitPrice = isset($_SESSION['unitPrice']) ? $_SESSION['unitPrice'] : '';
	$totalPrice = isset($_SESSION['totalPrice']) ? $_SESSION['totalPrice'] : '';
    
    switch ( $result )
        {
            case "CANCELED":
                $error = 'Notify. ';
                $errortext = "Операция оплаты отменена.";
                break;
            case "NOT APPROVED":
                $error = 'Error. ';
                switch ($responsecode)
                {   
                    case "04": 
                        $errortext = "Недейсвительный номер карты.";
                        break;
                    case "14": 
                        $errortext = "Неверный номер карты.";
                        break;
                    case "33":
                    case "54": 
                        $errortext = "Истек срок действия карты."; 
                        break;
                     case "Q1": 
                        $errortext = "Неверный срок дейсвия карты или карта просрочена. "; 
                        break;            
                    case "51":
                        $errortext = "Недостаточно средств.";
                        break;
                    case "56":
                        $errortext = "Неверный номер карты.";
                        break;
                    default:
                        $errortext = "Обратитесь в банк, выпустивший карту.";
                }
            break;
            case "CAPTURED":
                if ($responsecode == "00") {
                    $errortext = 'OK. ';      
                }
        }
 ?>

<html>
<head>
	<style type="text/css">
	<?php include "styles/style.css" ?>
	</style>
    <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
</head>
<body>
<center>
<table width="80%" style="border: 1px solid darkred;">
	<tr>
		<th><h1><font color="darkred">Your </font>Merchant Logo</h1></th>
	</tr>
</table>
<form name="transactionForm" action="UniversalPluginCheckoutPaymentInit.php" method="POST" >

<h3>
<?php
    echo $error . $errortext;
?>
</h3>

<table width="80%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td colspan="2"><h3>Order Summary</h3></td>
	</tr>
	<td colspan="2">
	<table width="100%" cellspacing="0" cellpadding="0" style="border: 1px solid black;">
		<tr style="background-color: lightblue;">
			<td>Track ID</td>
			<td>Order ID</td>
			<td>Reference #</td>
			<td>Post Date</td>
			<td>Transaction ID</td>
			<td>Auth Code#</td>
		</tr>
		<tr>
			<td><?php echo $trackid ?>&nbsp;</td>
			<td><?php echo $paymentid ?>&nbsp;</td>
			<td><?php echo $ref ?>&nbsp;</td>
			<td><?php echo $postdate ?>&nbsp;</td>
			<td><?php echo $tranid ?>&nbsp;</td>
			<td><?php echo $auth ?>&nbsp;</td>
		</tr>
	</table>
	</td>
	<tr>
		<th colspan="2"><hr /></th>
	</tr>
	<tr>
		<td colspan="2"><h3>Payment Information</h3></td>
	</tr>
	<tr>
		<td colspan="2">
		<table width="100%" cellspacing="0" cellpadding="0" style="border: 1px solid black;">
			<tr style="background-color: lightblue;">
				<td>Mfg Part#</td>
				<td>Sku #</td>
				<td>Item#</td>
				<td>Quantity</td>
				<td>Unit Price</td>
				<td>Total</td>
			</tr>
			<tr>
				<td>SDMX3-533GR</td>
				<td>2024470129</td>
				<td>F3PXLS</td>
				<td><?php echo $quantity ?>&nbsp;</td>
				<td><?php echo $unitPrice ?>&nbsp;</td>
				<td><?php echo $totalPrice ?>&nbsp;</td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<th colspan="2"><hr /></th>
	</tr>
	<tr>
		<td colspan="2"><h3>Transmission Information</h3></td>
	</tr>
	<tr>
		<td colspan="2">
			<table width="100%" cellspacing="0" cellpadding="2" style="border: 1px solid black;">
				<tr>
					<td width="20%" align="right"style="background-color: lightblue;">Result Code:</td>
					<td width="30%" ><?php echo $result ?>&nbsp;</td>
					<td width="20%" align="right"style="background-color: lightblue;">Response Code:</td>
					<td width="30%" ><?php echo $responsecode ?>&nbsp;</td>
				</tr>
				<tr>
					<td width="20%" align="right"style="background-color: lightblue;">Address Verification Check:</td>
					<td width="30%" ><?php echo $avr ?>&nbsp;</td>
					<td width="20%" align="right"style="background-color: lightblue;">Card Verification Check:</td>
					<td width="30%" ><?php echo $cvv2response ?>&nbsp;</td>
				</tr>
				<tr>
					<td width="20%" align="right" style="background-color: lightblue;">User Defined Field 1:</td>
					<td width="30%" ><?php echo $udf1 ?>&nbsp;</td>
					<td width="20%" align="right" style="background-color: lightblue;">User Defined Field 2:</td>
					<td width="30%" ><?php echo $udf2 ?>&nbsp;</td>
				</tr>
				<tr>
					<td width="20%" align="right" style="background-color: lightblue;">User Defined Field 3:</td>
					<td width="30%" ><?php echo $udf3 ?>&nbsp;</td>
					<td width="20%" align="right" style="background-color: lightblue;">User Defined Field 4:</td>
					<td width="30%" ><?php echo $udf4 ?>&nbsp;</td>
				</tr>
				<tr>
					<td width="20%" align="right" style="background-color: lightblue;">User Defined Field 5:</td>
					<td width="30%" ><?php echo $udf5 ?>&nbsp;</td>
					<td width="20%" align="right" style="background-color: lightblue;">&nbsp;</td>
					<td width="30%" >&nbsp;</td>
				</tr>
<?php
	if (strlen($pares) > 0) {
	    echo "				<tr>\r\n";
	    echo "				    <th colspan=\"4\">&nbsp;</th>\r\n";
	    echo "				</tr>\r\n";
	    echo "				<tr>\r\n";
	    echo "				    <td>PARes:</td><td colspan=\"3\"><textarea cols=\"80\" rows=\"10\">" . $pares . "</textarea></h4></td>\r\n";
	    echo "				</tr>\r\n";
	}
?>
			</table>
		</td>
	</tr>
	<tr>
		<th colspan="2">&nbsp;</th>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<input type="button" name="back" value="Return to Index" onClick="location.href='index.php'" class="checkoutButton">
		</td>
	</tr>
</table>

</form>
</center>
</body>
</html>
