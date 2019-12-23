<?php

	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		$id = clearData($_GET['id']);
		$row = getRecords("SELECT * FROM items WHERE id = '$id'");  // получаем информацию по данному id
	}
?>

<div class="article">	
<a href='index.php?page=catalog' style='margin-left:40px'>Назад</a>
<a href='index.php?page=edit&id=<?php echo $id; ?>' style='margin-left:20px'>Редактировать</a>
<br/><br/>
<table  border="1" style="text-align:left;" class="content" >
	<tr>
		<th  bgcolor="#e7e7e7">Название</th>
		<td style="width:300px;" ><?= $row[0]['name'] ?></td>
		<td rowspan="4"><img src='<?php echo $row[0]['image'].'.jpg';?> '></td>
	</tr>
	<tr>
		<th bgcolor="#e7e7e7">Категория</th>
		<td><?= $row[0]['category']?></td>
	</tr>
	<tr>
		<th bgcolor="#e7e7e7">Цена</th>
		<td><?= $row[0]['price'] ?> руб.</td>
	</tr>
	<tr >
		<th  bgcolor="#e7e7e7">Описание</th>
		<td valign="top"><?= $row[0]['description'] ?></td>
	</tr>
</table>
</div>
