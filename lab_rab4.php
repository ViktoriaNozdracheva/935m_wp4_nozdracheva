<div class="article">
<?php
	
	$host = "localhost";
	$user = "root";
	$password = "";
	$database = "labrab4";	
	$connect = mysqli_connect($host, $user, $password) or die('Ошибка соединения: ' . mysqli_error($connect));
	
	$query = "CREATE DATABASE IF NOT EXISTS ".$database." ";
	mysqli_query($connect,$query) or die('Ошибка при создании базы данных: ' . mysqli_error($connect));
	echo "База '$database' успешно создана <br>";
	mysqli_select_db($connect,$database);
	
	$query = "CREATE TABLE IF NOT EXISTS students (
        id integer not null auto_increment primary key,
        surname varchar(50) not null,
        name varchar(50) not null)";
	mysqli_query($connect,$query) or die('Ошибка при создании таблицы students: ' . mysqli_error($connect));
	echo "Таблица students успешно создана <br>";	
	
	$query = "CREATE TABLE IF NOT EXISTS exam (
        id integer not null auto_increment primary key,
		id_student varchar(10) not null,
        subject integer not null)";
	
	mysqli_query($connect,$query) or die('Ошибка при создании таблицы exam: ' . mysqli_error($connect));
	echo "Таблица zakaz успешно создана <br>";	
	
	echo "<br>Структура базы данных";
	get_column_names_with_meta($connect);    // выводим структуру БД до изменения
	echo "<br><br>";
	
	$query = "ALTER TABLE students ADD patronymic varchar(50) not null,ADD gruppa integer not null";	
	mysqli_query($connect,$query) or die('Ошибка при изменении таблицы students: ' . mysqli_error($connect));
	echo "Структура таблицы students успешно изменена\n";	
	echo "<br><br>";
	
	$query = "ALTER TABLE exam MODIFY id_student integer not null,MODIFY subject varchar(60) not null, ADD mark integer not null";	
	mysqli_query($connect,$query) or die('Ошибка при изменении таблицы exam: ' . mysqli_error($connect));
	echo "Структура таблицы exam успешно изменена\n";
		
	echo "<br><br>Измененная структура базы данных";
	get_column_names_with_meta($connect);	// выводим структуру БД после изменения
	viewData($connect);                     // заполняем таблицы и выводим их
	query1($connect);                       // запрос №1
	query2($connect);                       // запрос №2
	deleteDB($connect);                     //удаляем базу данных lab4
	
	
	
	
	function get_column_names_with_meta ($conn_id)
	{
		$query = "SELECT * FROM students,exam WHERE 1 = 0";
		if (!($result_id = mysqli_query ($conn_id,$query)))
			return (FALSE);
		echo "<table border='1' align='center'>";
		echo "<tr><th>Таблица</th><th>Поле</th><th>Тип</th><th>Длинна</th></tr>";
		for ($i = 0; $i < mysqli_num_fields ($result_id); $i++)
		{
			if ($field = mysqli_fetch_field ($result_id))
				echo "<tr>";
				echo "<td>".$field->table."</td>";
				echo "<td>".$field->name."</td>";
				echo "<td>".$field->type."</td>";
				echo "<td>".$field->length."</td>";
				echo "</tr>";
		}
		echo "</table>";
		mysqli_free_result ($result_id);
	}	
	
	
	function viewData($connect)
	{
		mysqli_query($connect,"INSERT INTO students (surname,name,patronymic,gruppa) values ('Иванов','Иван','Иванович',220)");
		mysqli_query($connect,"INSERT INTO students (surname,name,patronymic,gruppa) values ('Петров','Петр','Александрович',220)");
		mysqli_query($connect,"INSERT INTO students (surname,name,patronymic,gruppa) values ('Измаилов','Иван','Натанович',223)");
		mysqli_query($connect,"INSERT INTO students (surname,name,patronymic,gruppa) values ('Семенов','Семен','Анотольевич',221)");
		mysqli_query($connect,"INSERT INTO students (surname,name,patronymic,gruppa) values ('Дюба','Артем','Владимирович',221)");
		mysqli_query($connect,"INSERT INTO students (surname,name,patronymic,gruppa) values ('Ерушин','Стас','Михайлович',221)");
		$rows = resultSetArray(mysqli_query($connect,"SELECT * FROM students ORDER BY gruppa ASC"));			
		echo "<br>Таблица students:<br>";		
		echo "<table border='1' align='center' width='600'>";
		echo "<tr><th>ID</th><th>Фамилия</th><th>Имя</th><th>Отчество</th><th>группа</th></tr>";
		foreach ($rows as $row)
		{
			echo "<tr>";
			echo "<td>".$row['id']."</td>";
			echo "<td>".$row['surname']."</td>";
			echo "<td>".$row['name']."</td>";
			echo "<td>".$row['patronymic']."</td>";
			echo "<td>".$row['gruppa']."</td>";
			echo "</tr>";
		}
		echo "</table><br>";
		
		mysqli_query($connect,"INSERT INTO exam (id_student,subject,mark) values ('1','Алгоритмизация',7)");
		mysqli_query($connect,"INSERT INTO exam (id_student,subject,mark) values ('1','Бух учет',5)");
		mysqli_query($connect,"INSERT INTO exam (id_student,subject,mark) values ('2','Алгоритмизация',9)");
		mysqli_query($connect,"INSERT INTO exam (id_student,subject,mark) values ('3','Алгоритмизация',3)");
		mysqli_query($connect,"INSERT INTO exam (id_student,subject,mark) values ('3','Высшая математика',4)");
		mysqli_query($connect,"INSERT INTO exam (id_student,subject,mark) values ('3','Алгоритмизация',2)");
		mysqli_query($connect,"INSERT INTO exam (id_student,subject,mark) values ('4','Алгоритмизация',10)");
		mysqli_query($connect,"INSERT INTO exam (id_student,subject,mark) values ('5','Алгоритмизация',2)");
		mysqli_query($connect,"INSERT INTO exam (id_student,subject,mark) values ('5','Компьютерная графика',6)");
		mysqli_query($connect,"INSERT INTO exam (id_student,subject,mark) values ('5','Базы данных',5)");	
		$rows = resultSetArray(mysqli_query($connect,"SELECT subject,mark,concat(Surname,' ',left(name,1),'.',left(patronymic,1),'.') as 'fio',gruppa 
														FROM exam left join students on students.id=exam.id_student ORDER BY subject ASC"));			
		echo "<br>Таблица exam:<br>";		
		echo "<table border='1' align='center' width='600'>";
		echo "<tr><th>Группа</th><th>Фио</th><th>Предмет</th><th>Оценка</th></tr>";
		foreach ($rows as $item)
		{
			echo "<tr>";
			echo "<td>".$item['gruppa']."</td>";
			echo "<td>".$item['fio']."</td>";
			echo "<td>".$item['subject']."</td>";
			echo "<td>".$item['mark']."</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
	
	function query1($connect)
	{
		echo "<br><b>Запрос №1:</b> Вывести оценки Дюбы и отсортировать по предметам по возрастанию<br>";
		$rows = resultSetArray(mysqli_query($connect,"SELECT concat(surname,' ',left(name,1),'.',left(patronymic,1),'.') as 'fio',subject,mark FROM students 
														LEFT JOIN exam on exam.id_student = students.id 
														WHERE surname like '%Дюба%' ORDER BY subject ASC"));			
		echo "<table border='1' align='center' width='600'>";
		echo "<tr><th>ФИО</th><th>Предмет</th><th>Оценка</th></tr>";
		foreach ($rows as $row)
		{
			echo "<tr>";
			echo "<td>".$row['fio']."</td>";
			echo "<td>".$row['subject']."</td>";
			echo "<td>".$row['mark']."</td>";			
			echo "</tr>";
		}
		echo "</table>";
		
	}
	
	function query2($connect)
	{
		echo "<br><b>Запрос №2:</b> Вывести по группам количество человек сдавших экзамен по алгоритмизации на неуд.(оценка < 5) и отсортировать по группам по возрастанию<br>";		
		$rows = resultSetArray(mysqli_query($connect,"SELECT gruppa,count(gruppa) as 'kol' from students 
														left join exam on students.id = exam.id_student WHERE subject='Алгоритмизация' and mark<5 GROUP BY gruppa ORDER BY gruppa ASC"));			
		echo "<table border='1' align='center' width='600'>";
		echo "<tr><th>Группа</th><th>Количество неудов</th></tr>";
		foreach ($rows as $item)
		{
			echo "<tr>";
			echo "<td>".$item['gruppa']."</td>";
			echo "<td>".$item['kol']."</td>";
			echo "</tr>";
		}
		echo "</table>";
	}

	
	function deleteDB($connect){
		$query = "DROP DATABASE labrab4";
		mysqli_query($connect,$query) or die('Ошибка при удалении БД: ' . mysqli_error($connect));
		echo "<br>База ".$database." успешно удалена\n";			
		mysqli_close($connect);
	}
?>
</div>
