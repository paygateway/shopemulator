<!DOCTYPE html>
<html class="inside  big-inside">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>e-POS: эмулятор магазина</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
	<link
		href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300italic,400italic,700italic,400,300,700&subset=latin,cyrillic-ext'
		rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="css/inside.css">


</head>
<body class="inside">

<div class="container">
	<nav class="navbar navbar-default">
		<ul class="nav navbar-nav">
			<li><a href="index.php">НОВЫЙ ПЛАТЕЖ</a></li>
			<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">ОПЕРАЦИИ <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a href="ops.php">Проверка статуса</a></li>
					<li><a href="ops.php?action=terminate">Списание заблокированной суммы</a></li>
					<li><a href="ops.php?action=unblock">Разблокировка заблокированной суммы</a></li>
					<li><a href="ops.php?action=reversal">Частичный / полный возврат</a></li>
				</ul>
			</li>
		</ul>
	</nav>