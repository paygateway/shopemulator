<?php

	require_once "PHPUtils/Configuration.php";

	$Config = new Configuration('config.txt');
	
    $merchant = $Config->get('settings.merchant');
	$terminal = $Config->get('settings.terminal');
    $password = $Config->get('settings.password');
    $amount = 1.0;
    
    $trackid = time();
    
    $action = '1';
    
    if ( isset($_REQUEST['amount']) ) $amount = $_REQUEST['amount'];
    if ( isset($_REQUEST['action']) ) $action = $_REQUEST['action'];
        
    // Hash signature
    //$hash_pass = sha1( $password );
    $hash_pass = $password;
    $solt = $merchant . $amount . $trackid . $action . $hash_pass;
    $hash = sha1($solt);
    
    // Http POST request
    $url = 'https://ecm.sngb.ru:443/ECommerce/PaymentInitServlet';      
    //$url = 'https://app-cg-test.sngb.local:8443/ECommerce/PaymentInitLocal';
    
    $params = array(
        'merchant' => $merchant ,
        'terminal' => $terminal ,
        'action' => $action ,
        'amt' => $amount ,
        'trackid' => $trackid ,
        'udf5' => $hash ,
        'udf1' => 'Test PaymentInit' 
        );
    
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
<html>
<head>
	<style type="text/css">
	<?php include "styles/style.css" ?>
	</style>
    <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
</head>
<body OnLoad="OnLoadEvent();">
 
    <div><b>result=</b>:&nbsp <?php echo $result ?> </div> 

    <form action="<?php echo $result ?>" method="post" name="form1" autocomplete="off">
        <input type="submit" name="proceed" value="Proceed to Checkout" class="checkoutButton">
    </form>
    <script language="JavaScript">

    function OnLoadEvent() {
       document.form1.submit();
       timVar = setTimeout("procTimeout()",300000);
    }

    function procTimeout() {
       location = 'http://enter.a.timeout.url.here';
    }

    //
    // disable page duplication -> CTRL-N key
    //
    if (document.all) {
        document.onkeydown = function () {
            if (event.ctrlKey && event.keyCode == 78) {
                return false;
            }
        }
    } 
    </script>
    
</body>
</html>

