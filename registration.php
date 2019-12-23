<?php
	$error="";
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if (!empty($_POST['password']) && !empty($_POST['login']) && !empty($_POST['email'])) 
        {               
			$password = md5(md5(clearData($_POST['password']).'univer'));   // хэшируем пароль 
			$login = clearData($_POST['login']);
			$email = clearData($_POST['email']);  
			$fio = clearData($_POST['fio']);    
			$telephone = clearData($_POST['telephone']);  			
			connectDB();		
			$query ="SELECT id FROM users where login = '$login' or email = '$email'";		// проверяем нет ли пользователя с таким логином или email
			$result = getRecords($query);		
			if(!empty($result))
				$error = "<p align='center'><font color=red>Пользователь с таким логином или email уже существует!</font></p>";			
			else 
			{
				$query ="INSERT INTO users (login,password,email,fio,telephone) VALUES ('$login','$password','$email','$fio','$telephone')";			
				doQuery($query);
				header("Location: index.php?login=".$login); 			
			}	          
        }
        else 
			$error = "<p align='center'><font color=red>Заполните все обязательные поля!</font></p>";
    }
?>
<div class="article">
	<table class="content">
		<tr>
			<td>		
				<h2 align="center">Регистрация</h2>
				<form method="POST">
					<table>
						<tr>
							<td ><font color="red">*</font></td>
							<td >Логин </td>
							<td><input type="text" name="login" required></td>
						</tr>
						<tr>
							<td ><font color="red">*</font></td>
							<td>Пароль</td>
							<td><input type="password" name="password" required></td>
						</tr>		
						</tr>      
						<tr>
							<td> <font color="red">*</font></td>
							<td>Email</td>
							<td><input type="email" name="email" size="40" required></td>
						</tr>
						<tr>
							<td ></td>
							<td>ФИО</td>
							<td><input type="text" name="fio" size="70"></td>
						</tr>
						<tr>
							<td ></td>
							<td>Телефон</td>
							<td><input type="text" name="telephone" size="20"></td>
						</tr>
					</table>
					<p align="center">
						<input type="submit" value="Зарегистрироваться">
						<input type="reset" value="Сброс">
					</p>
					<?php echo $error; ?>
					<br>
					<font color="red">*</font> - Обязательные поля для заполнения
				</form>
			</td>
		</tr>
	</table>
</div>
