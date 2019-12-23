<?php
	function getMenu($menu, $vertical=true)
	{	
		echo '<ul>';
			foreach ($menu as $link=>$href)
			{
				echo "<li><a href=\"$href\">", $link, '</a></li>';
			}		
		echo '</ul>';
	}
	
	
	function userSort($arr){	
		echo "<b>Исходный массив:</b><br>";
		// выводим исходный массив
		foreach ($arr as $key => $val) { 
			echo "arr[" . $key . "] = " . $val . "<br>";
		}
	    
		// сортируем массив
		$array_length = sizeof($arr);
		for($x = 0; $x < $array_length; $x++) { 
			for($y = 0; $y < $array_length; $y++) {  
				if(strcasecmp($arr[$x],$arr[$y])<0) {   
					$hold = $arr[$x];
					$arr[$x] = $arr[$y];
					$arr[$y] = $hold;
				}
			}
		 }
		echo "<br>";
		echo "<b>Массив после сортировки:</b><br>";
		// выводим отсортированный пользовательской функцией массив
		foreach ($arr as $key => $val) { 		
			echo "arr[" . $key . "] = " . $val . "<br>";
		}
	}
	
	
	function clearData($data)
	{
		return trim(strip_tags($data));
	}
	
	function loadImage(){ 
		if ($_FILES['img']['type'] != 'image/jpeg') {
			echo '<font color="red" align="center" >Не верный тип изображения!</font>';
			return "";
		}		
		else
		{
			if ($_FILES['img']['size'] > 100000) {
				echo '<font color="red" align="center" >Превышен максимальный размер файла! (макс.=100кб.)</font>';
				return "";
			}
			else
			{
				$Image = imagecreatefromjpeg($_FILES['img']['tmp_name']); 
				$Size = getimagesize($_FILES['img']['tmp_name']); 
				$Tmp = imagecreatetruecolor(300, 300);
				imagecopyresampled($Tmp, $Image, 0, 0, 0, 0, 300, 300, $Size[0], $Size[1]);
				if (isset($_POST["add"])){
					$lastid = getRecords("select id from items order by id desc");
					$img = 'images/catalog/'.($lastid[0]['id'] + 1);
				}
				else {
					$t = getRecords("select image from items where id = ".$_GET['id']."");					
					$img = $t[0]['image'];
				}
				if (strpos($img,"default")>0) $img = 'images/catalog/'.$_GET['id'];
				imagejpeg($Tmp, $img.'.jpg'); // сохраняем 
				imagedestroy($Image);
				imagedestroy($Tmp);
			}		
		}
		return $img;
	}	
	
	$connect = false;
	function connectDB(){   // функция подключения к БД
		global $connect;
		include "base_reg.php";
		$connect = mysqli_connect($host, $user, $password, $database) or die("Не удалось подключиться к БД"); // подключение к базе данных			
		mysqli_set_charset($connect,"utf8");
	}	
	
	function getRecords($query){ // функция получения записи из БД
		global $connect;
		connectDB();
		$result_set = mysqli_query($connect,$query) or die("Ошибка получения записи" . mysqli_error($connect));
		closeDB();
		return resultSetArray($result_set);
	}
	
	function doQuery($query){  // функция выполнения запросов, которые не возвращают данные (INSERT,UODATE,DELETE и т.д)
		global $connect;
		connectDB();
		$result_set = mysqli_query($connect,$query) or die("Ошибка выполнения запроса" . mysqli_error($connect));
		closeDB();		
	}	
	
	function resultSetArray($result_set){  // функция преобразования полученных данных из БД в ассоциативный массив
		$array =array();
		while (($row = $result_set->fetch_assoc()) !=false)
			$array[] = $row;
		return $array;
	}		
	
	function closeDB() {  // закрытие соединения с БД
		global $connect;
		mysqli_close($connect);
	} 
	
?>