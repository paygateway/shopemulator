 <?php              
        require_once "PHPUtils/Configuration.php"; 
        
        // Merchant information
        $Config = new Configuration('config.txt'); 	
        $merchant = $Config->get('settings.merchant');
        $terminal = $Config->get('settings.terminal');
        $password = $Config->get('settings.password');
          
        // Transaction information
        $amount = isset($_REQUEST['amount']) ? $_REQUEST['amount']: ''; 
        $action = isset($_REQUEST['action']) ? $_REQUEST['action']: '';  
        $paymentid = isset($_REQUEST['paymentid']) ? $_REQUEST['paymentid']: '';
        $trackid = isset($_REQUEST['trackid']) ? $_REQUEST['trackid']: '';
        $tranid = isset($_REQUEST['tranid']) ? $_REQUEST['tranid']: '';
                         
        // Hash signature
        $hash_pass = sha1( $password );                   
        $solt = $merchant . $amount . $trackid . $hash_pass;         
        $hash = sha1($solt);
        
        // Http POST request
        $url = 'https://ecm.sngb.ru:443/ECommerce/PaymentTranServlet';      
        //$url = 'https://app-cg-test.sngb.local:8443/ECommerce/PaymentTranLocal';
        
        $params = array(
            'merchant' => $merchant ,
            'terminal' => $terminal ,
            'action' => $action ,
            'amt' => $amount ,
            'hash_str' => $hash ,
            'paymentid' => $paymentid ,
            'trackid' => $trackid ,            
            'tranid' => $tranid ,
            'udf1' => 'Test PaymentTran' 
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
        
        /*        
            CAPTURED
            APPROVED
            VOIDED
            NOT CAPTURED
            NOT APPROVED
            NOT VOIDED
            DENIED BY RISK
            FAILED AVS
            HOST TIMEOUT 
        */
        echo 'result=' . $result;
            
        if ( $result == '00' ) {
            $url = 'NotificationTranLog.php';
        } else {
            $url = 'Failure.php';
        }
?>
<html>
<head>
	<style type="text/css">
	<?php include "styles/style.css" ?>
	</style>
    <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
</head>
<body OnLoad="OnLoadEvent();">
 
    <div><b>result=</b>:&nbsp <?php echo $url ?> </div> 

    <form action="<?php echo $result ?>" method="post" name="form1" autocomplete="off">
        <input type="hidden" name="PaymentID" value="<?php echo $paymentId ?>"  />  
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

