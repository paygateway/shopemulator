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
<form name="transactionForm" action="PaymentInit.php" method="POST" >
<table width="80%">
	
    <tr>
		<th colspan="2">Shopping Cart Checkout</th>
	</tr>
	
    <tr>
		<th colspan="2"><hr/></th>
	</tr>
	
    <tr>
		<td colspan="2">
			  <table cellspacing="0" cellpadding="0">
			    <tr>
                    <td rowspan="5"><image src="images/jacket.gif"/></td>
                    <td>Manufacturer: Applied Communications Inc.</td>
			    </tr>			    			   
			  </table>
		</td>
	</tr>
	
    <tr>
		<th colspan="2"><hr/></th>
	</tr>
	
    <tr>
		<td align="right">Amount:</td>
		<td><input type="text" name="amount" size="10" value="123.45"/></td>
	</tr>
    
    <tr>
		<td align="right">Action:</td>
		<td>
            <input type="radio" name="action" size="10" value="1" checked="true">Purchace</input>
            <input type="radio" name="action" size="10" value="4">Authorization</input>
        </td>
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
