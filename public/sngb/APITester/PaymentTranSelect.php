<?php
    require_once "PHPUtils/Configuration.php";       
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
<form name="transactionForm" action="PaymentTranAccept.php" method="GET" >
<table width="80%">
	
    <tr>
		<th colspan="2">Shopping Cart Checkout</th>
	</tr>
	
    <tr>
		<th colspan="2"><hr/></th>
	</tr>
	
    <tr>
		<td colspan="2">
			  <table cellspacing="0" cellpadding="0" border="1">             
<?php         
    echo "<tr>";                
        echo "<th>" . '' . "</th>";
        echo "<th>" . 'n/n' . "</th>";
        echo "<th>" . 'paymentID' . "</th>";
        echo "<th>" . 'result' . "</th>";
        echo "<th>" . 'trackid' . "</th>";
        echo "<th>" . 'tranid' . "</th>";
        echo "<th>" . 'error' . "</th>";
        echo "<th>" . 'errortext' . "</th>";
                
    echo "</tr>";
    
    $pk = 'id';
    $Config = new Configuration('db.lst');               
    $tran = $Config->getKeys();
        
    $i = 0;
    $last = ( count($tran)-10 );
    foreach( $tran as $ID ) {
        $i = $i + 1;                        
        
        if ( $i > $last )  {
            $paymentid    = $Config->get($ID . '.paymentid');
            $result       = $Config->get($ID . '.result');
            $trackid      = $Config->get($ID . '.trackid');
            $tranid       = $Config->get($ID . '.tranid');
            $error        = $Config->get($ID . '.error');
            $errortext    = $Config->get($ID . '.errortext');
        
            echo '<tr>';                
            
            echo '<td>' . '<input type="radio" name="' . $pk . '" ';
            if ( $i == $last ) echo 'checked="true" ';
            echo 'value="' . $ID .'"></input>' . '</td>';
            
            echo '<td>' . $i . "</td>";
            echo '<td>' . $paymentid . "</td>";
            echo '<td>' . $result . "</td>";
            echo '<td>' . $trackid . "</td>";
            echo '<td>' . $tranid . "</td>";
            echo '<td>' . $error . "</td>";
            echo '<td>' . $errortext . "</td>";
                            
            echo "</tr>";
            echo "\r\n";
        }                
    }
?>              
			  </table>
		</td>
	</tr>
	
    
    <tr>
		<th colspan="2"><hr/></th>
	</tr>
	  
    <tr>
		<td align="right">Amount:</td>
		<td><input type="text" name="amount" size="100" value="123.45"/></td>
	</tr>
    
    <tr>
		<td align="right">Action:</td>               
		<td>      
            <input type="radio" name="action" value="2" checked="true">Creadit<br>            
            <input type="radio" name="action" value="5">Capture<br>
            <input type="radio" name="action" value="6">Void Credit<br>
            <input type="radio" name="action" value="7">Void Capture<br>
            <input type="radio" name="action" value="9">Void Authorization<br>
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
