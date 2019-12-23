<?php
	$error="";
	if (isset($_POST['login']) && isset($_POST['password']))
	{	 
		if (!empty($_POST['login']) && !empty($_POST['password']))
		{
			$login = clearData($_POST['login']);
			$password =  md5(md5(clearData($_POST['password']).'univer')); 		
			connectDB();		
			$query ="SELECT id FROM users where login = '$login' and password = '$password'";	
			$result = getRecords($query);			
			if(!empty($result))
			{				
				$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
				$_SESSION['login'] = $login;
				header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
				exit;
			}
			else 
				$error="Неверный логин или пароль!";				
		}
		else 
			$error="Заполните все поля!";
	}
?>
<div class="index-text-1">Вход в систему</div>		
<div class="article">
	<form method="POST">
		<p>Логин:<input type="text" name="login" style="margin-left:20px;" value="<?php if (isset($_GET['login'])) echo $_GET['login']; ?>"></p>
		<p>Пароль:<input type="password" name="password" style="margin-left:10px;"></p>
		<p><input type="submit" value="Авторизоваться" id="submit"></p>
		<p><a href="index.php?page=registration" style="font-size:25px;">Регистрация</a><p>
	</form>
	<br>
	<font color="red"><?php echo $error; ?></font>
</div>
