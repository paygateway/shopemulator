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
 // The purpose of the UniversalPluginCheckoutSuccess.php is to provide
 // a way for the Commerce Gateway to tell the merchant, outside of the
 // consumer flow, the status of the payment after all authentication is complete.
 // This page allows the merchant to decide, based on the hosts reply where to
 // redirect the user.
 //
 // This page can be implemented as a servlet and should always return ONE line,
 // without any carriage-return/linefeed containing the URL the merchant wants
 // the user to be redirected to prededed by the command string "REDIRECT="
 //
 // Because this page is performed using a DIFFERENT SESSION than the consumer,
 // the $_SESSION object may not be used to store the information.  Some other form of
 // persistance is required and to allow matching up of the data acquired here when the
 // consumer is redirected, a unique value (we use the paymentid here as an example) should be
 // used.
 //
 // An example of a value reply (without any carriage-return/linefeed) is:
 //
 // REDIRECT=http://yourdemobank/UniversalTester/UniversalPluginCheckoutReceipt.php?paymentid=2060005351572270
 //

	require_once "PHPUtils/ACIPHPUtils.php";
	require_once "PHPUtils/Configuration.php";

	$currentContext = ACIPHPUtils::getContextPath($HTTP_SERVER_VARS);

	$paymentID  = $_REQUEST['paymentid'];
	$error      = $_REQUEST['Error'];			// The Notification servlet/page, unlike the Universal Servlet's replies, still uses: Error instead of error_code_tag
	$errortext  = $_REQUEST['ErrorText'];       // The Notification servlet/page, unlike the Universal Servlet's replies, still uses: ErrorText instead of error_text
    try {
		// You Would NOT EVER DO THIS IN PRODUCTION as it is a security concern.. instead, merchants should serialize the order data to a database.
		if (!strcmp($error, "")) {
			$Config = new Configuration('orders.lst');
			$Config->set($paymentID . '.result',    $_REQUEST['result']);
			$Config->set($paymentID . '.error',     $_REQUEST['error']);
			$Config->set($paymentID . '.errortext', $_REQUEST['errortext']);
			$Config->set($paymentID . '.ref',       $_REQUEST['ref']);
			$Config->set($paymentID . '.responsecode', $_REQUEST['responsecode']);
			$Config->set($paymentID . '.cvv2response', $_REQUEST['cvv2response']);
			$Config->set($paymentID . '.postdate',  $_REQUEST['postdate']);
			$Config->set($paymentID . '.udf1',      $_REQUEST['udf1']);
			$Config->set($paymentID . '.udf2',      $_REQUEST['udf2']);
			$Config->set($paymentID . '.udf3',      $_REQUEST['udf3']);
			$Config->set($paymentID . '.udf4',      $_REQUEST['udf4']);
			$Config->set($paymentID . '.udf5',      $_REQUEST['udf5']);
			$Config->set($paymentID . '.tranid',    $_REQUEST['tranid']);
			$Config->set($paymentID . '.auth',      $_REQUEST['auth']);
			$Config->set($paymentID . '.avr',       $_REQUEST['avr']);
			$Config->set($paymentID . '.trackid',   $_REQUEST['trackid']);
            $Config->set($paymentID . '.preved',   $_REQUEST['preved']);
			$Config->save();

			$reply      = "REDIRECT=" . $currentContext . "ResponseReceipt.php?paymentid=" . $paymentID;
	    } else {
	        $reply      = "REDIRECT=" . $currentContext . "ResponseFailure.php?error=" .  $error . "&errortext=" .  $errortext;
	    }
    } catch (Exception $e) {
		$reply      = "Error Occurred During Notification: " . $e;
    }

	// Now reply with the redirection value.
	echo $reply;

	// Note: There is no Carriage Return after this block as Commerce Gateway does not handle Carriage Returns in the REDIRECT instruction well.
 ?>