<?php
 //
 // An example of a value reply (without any carriage-return/linefeed) is:
 //
 // REDIRECT=http://yourdemobank/UniversalTester/UniversalPluginCheckoutReceipt.php?paymentid=2060005351572270
 //

	require_once "PHPUtils/ACIPHPUtils.php";
	require_once "PHPUtils/Configuration.php";

	$currentContext = ACIPHPUtils::getContextPath($HTTP_SERVER_VARS);

     // Primary Key
    $pk = 'tranid';    
	
    $ID  = $_REQUEST[ $pk ];    
	$error      = $_REQUEST['Error'];			// The Notification servlet/page, unlike the Universal Servlet's replies, still uses: Error instead of error_code_tag
	$errortext  = $_REQUEST['ErrorText'];       // The Notification servlet/page, unlike the Universal Servlet's replies, still uses: ErrorText instead of error_text
    try {
		// You Would NOT EVER DO THIS IN PRODUCTION as it is a security concern.. instead, merchants should serialize the order data to a database.
		if (!strcmp($error, "")) {
			$Config = new Configuration('db.lst');
            $Config->set($ID . '.paymentid', $_REQUEST['paymentid']);
			$Config->set($ID . '.result',    $_REQUEST['result']);
			$Config->set($ID . '.error',     $_REQUEST['error']);
			$Config->set($ID . '.errortext', $_REQUEST['errortext']);
			$Config->set($ID . '.ref',       $_REQUEST['ref']);
			$Config->set($ID . '.responsecode', $_REQUEST['responsecode']);
			$Config->set($ID . '.cvv2response', $_REQUEST['cvv2response']);
			$Config->set($ID . '.postdate',  $_REQUEST['postdate']);
			$Config->set($ID . '.udf1',      $_REQUEST['udf1']);
			$Config->set($ID . '.udf2',      $_REQUEST['udf2']);
			$Config->set($ID . '.udf3',      $_REQUEST['udf3']);
			$Config->set($ID . '.udf4',      $_REQUEST['udf4']);
			$Config->set($ID . '.udf5',      $_REQUEST['udf5']);
			$Config->set($ID . '.tranid',    $_REQUEST['tranid']);
			$Config->set($ID . '.auth',      $_REQUEST['auth']);
			$Config->set($ID . '.avr',       $_REQUEST['avr']);
			$Config->set($ID . '.trackid',   $_REQUEST['trackid']);
			$Config->save();

			$reply      = "REDIRECT=" . $currentContext . "CheckTran.php?" . $pk . '=' . $ID;
	    } else {
	        $reply      = "REDIRECT=" . $currentContext . "Error.php?error=" .  $error . "&errortext=" .  $errortext;
	    }
    } catch (Exception $e) {
		$reply      = "Error Occurred During Notification: " . $e;
    }

	// Now reply with the redirection value.
	echo $reply;
    //echo "redirect=" . $paymentID;

	// Note: There is no Carriage Return after this block as Commerce Gateway does not handle Carriage Returns in the REDIRECT instruction well.
 ?>