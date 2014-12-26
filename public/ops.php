<?php

require_once( '../config/config.php' );

$config = getConfig();

$action = $_GET['action'];

if ( empty( $action ) ) {
	$action = 'check';
}

if ( ! in_array( $action, array( 'check', 'terminate', 'reversal', 'unblock' ) ) ) {
	echo 'Unsupported action type';
	exit;
}

$h1 = '';
switch ( $action ) {
	case 'check':
		$h1 .= 'ПРОВЕРКА СТАТУСА ПЛАТЕЖА';
		break;
	case 'terminate':
		$h1 .= 'СПИСАНИЕ ЗАБЛОКИРОВАННОЙ СУММЫ';
		break;
	case 'reversal':
		$h1 .= 'ЧАСТИЧНЫЙ/ПОЛНЫЙ ВОЗВРАТ ОПЛАЧЕННОЙ СУММЫ';
		break;
	case 'unblock':
		$h1 .= 'РАЗБЛОКИРОВКА ЗАБЛОКИРОВАННОЙ СУММЫ';
		break;
}
include_once('header.php');
?>
	<h1><?php echo $h1; ?></h1>

	<form action="operate.php" method="POST" role="form">
		<div class="form-group">
			<label for="transID">TransID:</label>
			<input type="text" class="form-control" id="transID" name="transID">
		</div>
		<input type="hidden" name="opertype" value="<?php echo $action; ?>">
		<?php if ( $action != 'check' && $action != 'unblock' ) { ?>
			<div class="form-group">
				<label for="amount">Сумма:</label>
				<input type="text" class="form-control" id="amount" name="amount" value="10">
			</div>
		<?php } ?>
		<div class="form-group">
			<label for="account">№ л/с:</label>
			<input type="text" class="form-control" id="account" name="account" value="<?php echo $config['account']; ?>">
		</div>
		<div class="form-group">
			<label for="key1">Ключ 1:</label>
			<input type="text" class="form-control" id="key1" name="key1" value="<?php echo $config['key1']; ?>">
		</div>
		<div class="form-group">
			<label for="key2">Ключ 2:</label>
			<input type="text" class="form-control" id="key2" name="key2" value="<?php echo $config['key2']; ?>">
		</div>
		<input type="submit" class="btn3d-default btn btn-default btn-lg" name="submit" value="Проверить">
	</form>
<?php include_once('footer.php');