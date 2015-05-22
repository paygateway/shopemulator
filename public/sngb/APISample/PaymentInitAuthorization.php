<html>
<head>
	<style type="text/css"></style>
    <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">    
</head>

<body>
    
    /**
	 * 1 - Purchace; 
	 * 2 - Credit; 
	 * 3 - Void Purchace;
	 * 4 - Authorization;
	 * 5 - Capture;
	 * 6 - Void Credit;
	 * 7 - Void Capture;
	 * 8 - Query
	 * 9 - Void Authorization;
	 */

    <?php
    
        // Merchant information
        $merchant = '1037';
        $terminal = '1037-local';        
        $password = 'password';        
        $amount = '10';
        
        // Transaction information
        $trackid = time(); 
        
        // Hash signature
        $hash_pass = md5( $password );
        $solt = $merchant . $amount . $trackid . $hash_pass;         
        $hash = md5($solt);
        
        // Http POST request
        $url = 'https://ecm.sngb.ru:443/ECommerce/PaymentInitServlet'; 
        //$url = 'https://app-cg-test.sngb.local:8443/ECommerce/PaymentInitLocal'; 
        
        $params = array(
            'merchant' => $merchant ,
            'terminal' => $terminal ,
            'action' => '4' ,
            'amt' => $amount ,
            'trackid' => $trackid ,
            'hash_str' => $hash ,
            'udf1' => '1' ,
            'udf2' => '2' ,
            'udf3' => '3' ,
            'udf4' => '4' ,
            'udf5' => '5'     );
        
        // Param string
        $postdata = "";
        foreach ( $params as $key => $value ) $postdata .= "&".rawurlencode($key)."=".rawurlencode($value);

        // Do POST
        $ch = curl_init();
        curl_setopt ($ch, CURLOPT_URL, $url );
        curl_setopt ($ch, CURLOPT_POST, 1 );
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $postdata );
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec ($ch);
        curl_close($ch);
         
        echo 'result = ' . $result;
        
    ?>
        
    <h1>Authorization</h1>
     
    <form id="form4" action="<?php echo $result; ?>" method="post" name="form4" autocomplete="off">                  
        <input type="submit" name="proceed" value="Proceed to Checkout" class="checkoutButton">
    </form> 
    
</body>
</html>