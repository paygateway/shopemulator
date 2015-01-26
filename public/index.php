<?php

require_once( '../config/config.php' );

$config = getConfig();

if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	require '../vendor/autoload.php';
	$data              = $_POST;
	$description       = urlencode( $data['description'] );
	$data['signature'] = "{$data['amount']}:{$data['amountcurr']}:{$data['currency']}:";
	$data['signature'] .= "{$data['number']}:{$description}:{$data['trtype']}:{$data['account']}:{$data['key1']}:{$data['key2']}";
	$data['signature'] = strtoupper( md5( $data['signature'] ) );

	$client = new \GuzzleHttp\Client( [ 'cookies' => true ] );

	$response = $client->post( $config['epos_start_url'], [
		'body'    => $data,
		'cookies' => true
	] );

	$values = $response->getHeader( 'Set-Cookie', true );

	header( 'Location: ' . $response->getEffectiveUrl() );
} else {
	include_once( 'header.php' );
	?>
	<h1>ОПЛАТА ЗАКАЗА: первый шаг</h1>
	<?php
	require_once( '../config/config.php' );
	?>
	<form action="testpay.php" method="POST" role="form" style="width: 60%; margin-right: auto; margin-left: auto;">
		<div class="form-group">
			<label for="amount">Сумма платежа:</label>
			<input type="text" id="amount" name="amount" class="form-control" value="10.23">
		</div>
		<div class="form-group">
			<label for="amountcurr">Валюта платежа:</label>
			<select id="amountcurr" class="form-control" name="amountcurr">
				<option value="RUB">Российский рубль</option>
				<option value="USD">Доллар США</option>
				<option value="EUR">Евро</option>
			</select>
		</div>
		<div class="form-group">
			<label for="currency">Платежная система:</label>
			<select id="currency" class="form-control" name="currency">
				<option value="">Не выбрано</option>
				<option value="MBC">Банковские карты (Visa, Mastercard)</option>
			</select>
		</div>
		<div class="form-group">
			<label for="number">Номер заказа:</label>
			<input type="text" class="form-control" id="number" name="number" value="<?php echo time(); ?>">
		</div>
		<div class="form-group">
			<label for="description">Назначение платежа:</label>
			<textarea id="description" class="form-control" name="description">Тестовая оплата чегототам</textarea>
		</div>
		<div class="form-group">
			<label for="trtype">Тип транзакции:</label>
			<select id="trtype" class="form-control" name="trtype">
				<option value="1" selected>Списание</option>
				<option value="2">Блокировка</option>
			</select>
		</div>
		<div class="form-group">
			<label for="account">№ л/с:</label>
			<input type="text" class="form-control" id="account" name="account" value="<?php echo $config['account']; ?>">
		</div>
		<div class="form-group">
			<label for="backURL">BackURL:</label>
			<input type="text" class="form-control" id="backURL" name="backURL" value="<?php echo $config['shop_uri']; ?>">
		</div>
		<div class="form-group">
			<label for="key1">Ключ 1:</label>
			<input type="text" class="form-control" id="key1" name="key1" value="<?php echo $config['key1']; ?>">
		</div>
		<div class="form-group">
			<label for="key2">Ключ 2:</label>
			<input type="text" class="form-control" id="key2" name="key2" value="<?php echo $config['key2']; ?>">
		</div>
		<input type="submit" class="btn3d-default btn btn-default btn-lg" value="Оплатить">
	</form>
	<?php
	include_once( 'footer.php' );
}
