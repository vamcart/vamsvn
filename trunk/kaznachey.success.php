<?
header("Content-Type: text/html; charset=utf-8");

if ($_GET['Result'] == 'success') $mes = '<p class="valid">Спасибо! Ваш заказ #'.intval($_GET['OrderId']).' оплачен.</p>';

if ($_GET['Result'] == 'failed') $mes = '<p class="invalid">Платеж по заказу #'.intval($_GET['OrderId']).' не прошел, либо находится в обработке.</p>';

?>

<html>
	<head>
		<style>
			body{background-color: #527496; font: normal 13px Verdana,sans-serif;}
			.message_container{background-color: #fff; width: 50%; text-align:center; margin: auto; margin-top: 100px; padding: 50px;}
			.valid {color: green;}
			.invalid {color: red;}
		</style>
	</head>
	
	<body>
		<div class='message_container'>
			<h4><?=$mes;?></h4>
			<input type='button' value=' Закрыть ' onCLick="location='http://<?=$_SERVER['HTTP_HOST'];?>';">
		</div>
	
	
	</body>
</html>