<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>{title}</title>
	
	<!-- Main style -->
    <link href="{theme}css/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
	<div class="content">
	<div class="header">
		<div class="logo">BravelCMS</div>
		<div class="profile"><a href="#" id="open_pnav">Профиль</a></div>
		<ul class="pnav">
			<li class="active"><a href="#">Настройки</a></li>
			<li><a href="#">Выход</a></li>
		</ul>
	</div>
	<ul class="onav">
		<li class="active"><a href="#">Настройки</a></li>
		<li><a href="#">Системные модули</a></li>
		<li><a href="#">Дополнительные модули</a></li>
	</ul>
	<ul class="tnav">
		<li class="active"><a href="#">Основные настройки</a></li>
		<li><a href="#">Настройки кеширования</a></li>
		<li><a href="#">Meta теги</a></li>
		<li><a href="#">Meta теги</a></li>
		<li><a href="#">Meta теги</a></li>
	</ul>
	
	<form action="" method="POST">
		<p><label>Название сайта: </label><input class="right" type="text" /></p>
		<p><label>Описание сайта: </label><input class="right" type="text" /></p>
		<p><label>Ключевые слова: </label><input class="right" type="text" /></p>
		<p><input type="submit" class="ed_but" value="Изменить" /></p>
	</form>
	</div>
	
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="{theme}js/main.js"></script>
  </body>
</html>