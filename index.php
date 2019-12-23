<?php
	session_start();
	ob_start();
	ini_set('display_errors',1);
	date_default_timezone_set('Asia/Muscat');
	header("Content-Type: text/html; charset=utf-8");
	header("Cache-control: no-store");
	include "lib.inc.php";
	if (isset($_COOKIE['lastVisit']))
		$lastVisit = $_COOKIE['lastVisit'];
	setcookie('lastVisit',date('Y-m-d H:i:s'),time()+0xFFFFFFF);
	(empty($_GET['page']) ? $page = "" : $page = $_GET['page']);
	
	if (isset($_GET['logout'])) 
	{		
		session_destroy();
		header("Location: index.php");
		exit;
	}
?>


<!DOCTYPE html>

<html lang="en">

<head>
	<title>Учебный сайт "ВУЗ"</title>
	<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
	<?php include "blocks/top.inc.php" ?>	    
	<?php include "blocks/menu.inc.php" ?>
	<div>
		
		<?php
				if (isset($_SESSION['login']))	
				{									
					if (empty($page)) {
						echo '<div class="index-text-1">
								<p><b>Университет</b> — высшее учебное заведение, где готовятся специалисты по фундаментальным и многим прикладным наукам. Как правило, осуществляет и научно-исследовательскую работу. Многие современные университеты действуют как учебно-научно-практические комплексы. Университеты объединяют в своём составе несколько факультетов, на которых представлена совокупность различных дисциплин, составляющих основы научного знания.</p> 
								<p><b>Высшее образование</b> - это своеобразный признак интеллигентности и высокого уровня культуры личности.</p>
							</div>
							<div>
								<img class="index-glavnya-img" src="images/pic1.png" alt="фото университета">
								<video src="images/видео.mp4" width="400" height="150"  preload="auto" controls="controls"></video>
							</div>';
					}
					else
					{									
						switch($page)
						{
							case 'lab1': include 'lab_rab1.html'; break;
							case 'lab2': include 'lab_rab2.php'; break;
							case 'lab3': include 'lab_rab3.php'; break;	
							case 'lab4': include 'lab_rab4.php'; break;								
							case 'catalog': include 'catalog.php';break;	
							case 'add': include 'add.php'; break;
							case 'item': include 'item.php'; break;	
							case 'edit': include 'edit.php'; break;
						}
					}								
				}
				else
					($page=="registration" ? require 'registration.php' : require 'auth.php');				
				?>
		
	</div>

	<?php include "blocks/bottom.inc.php" ?>
</body>

</html>