<?php

require_once( '../config/config.php' );

$config = getConfig();

$params = $_REQUEST;

include_once('header.php');
?>

	<h1>ДАННЫЕ О ПЛАТЕЖЕ</h1>
	<table class="table">
		<thead>
		<tr>
			<th>Параметр</th>
			<th>Значение</th>
		</tr>
		</thead>
		<tbody>
		<tr>
			<td>amount</td>
			<td><?php echo $params['amount']; ?></td>
		</tr>
		<tr>
			<td>amountcurr</td>
			<td><?php echo $params['amountcurr']; ?></td>
		</tr>
		<tr>
			<td>number</td>
			<td><?php echo $params['number']; ?></td>
		</tr>
		<tr>
			<td>description</td>
			<td><?php echo urldecode($params['description']); ?></td>
		</tr>
		<tr>
			<td>transID</td>
			<td><?php echo $params['transID']; ?></td>
		</tr>
		<tr>
			<td>errorcode</td>
			<td><?php echo $params['errorcode']; ?></td>
		</tr>
		<tr>
			<td>errortext</td>
			<td><?php echo $params['errortext']; ?></td>
		</tr>
		</tbody>
	</table>
<?php include_once('footer.php');?>
