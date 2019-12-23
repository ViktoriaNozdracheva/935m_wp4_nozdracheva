<?php
	$menu = array(
		"Главная"=>"index.php", 
		"Работа №1"=>"index.php?page=lab1",
		"Работа №2"=>"index.php?page=lab2",
		"Работа №3"=>"index.php?page=lab3",
		"Работа №4"=>"index.php?page=lab4",
		"Каталог"=>"index.php?page=catalog");
?>	

<nav id="menu">
	<?php
		getMenu($menu);
	?>
</nav>

