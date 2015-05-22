<?php
	
    require_once('./PHPUtils/Configuration.php');
    
    $merchant = "";
    $terminal = "";
	$password = "";
	$savedMessage = "";   
	
    if ((isset($_REQUEST['Save']) && !strcmp($_REQUEST['Save'], "Save"))) {
		$merchant = $_REQUEST['merchant'];		
		$terminal = $_REQUEST['terminal'];        
        $password = $_REQUEST['password'];        
		// Save Settings.
		$Config = new Configuration('config.txt');
		$Config->set('settings.merchant', $merchant);
		$Config->set('settings.terminal', $terminal);
        $Config->set('settings.password', $password);        
		$Config->save();
		$savedMessage = "Configuration Saved Successfully.";
	} else {
		// Load the Settings.
		$Config = new Configuration('config.txt');
		$merchant = $Config->get('settings.merchant');
		$terminal = $Config->get('settings.terminal');
        $password = $Config->get('settings.password');
	}
    
?>
<html>
<head>
	<title>API Demo Website</title>
	<style type="text/css">
	<?php include "styles/style.css" ?>
	</style>
</head>
<body>
<form name="ConfigurationForm" action="Configuration.php" method="post">
<table width="100%" cellspacing="0" cellpadding="0" border = "0">
	<tr>
		<td colspan="2">
		  <table width="100%" cellspacing="0" cellpadding="0" border="0">
		    <tr>
		      <td><image src="images/acilogo.gif" border="0"></td><td align="Right"><H1 style="color:black;">API PHP Examples</H1></td>
		    </tr>
		    <tr>
		      <td colspan="2"><hr height="4" style="color:darkred;"/></td>
		    </tr>
		  </table>
		</td>
	</tr>
	<tr>
		<td colspan="2">Configuration Settings:</td>
	</tr>
	<tr>
		<th colspan="2"><hr/></th>
	</tr>
	<tr>
		<td align="right">Merchant:&nbsp</td>
		<td ><input name="merchant" type="input" size="80" value="<?php echo $merchant ?>"/>
	</tr>
    <tr>
		<td align="right">Terminal:&nbsp</td>
		<td ><input name="terminal" type="input" size="80" value="<?php echo $terminal ?>"/>
	</tr>
	<tr>
		<td align="right">Password:&nbsp</td>
        <td ><input name="password" type="password" size="80" value="<?php echo $password ?>"/>		
	</tr>
	<tr>
		<td colspan="2">
			<input type="button" name="back" value="Return to Index" onClick="location.href='index.php'" class="checkoutButton">
			<input type="submit" name="Save" value="Save" class="checkoutButton"/>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2"><?php echo $savedMessage ?></td>
	</tr>
</table>
</form>
</body>
</html>