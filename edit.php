<?php
	$id = clearData($_GET['id']);
	$row = getRecords("SELECT * FROM items WHERE id = '$id'");  // получаем всю информацию по данному id		
?>

<div class="index-text-1">Редактирование товара</div>		
<div class="article">
	<form method='POST' action='index.php?page=edit&id=<?php echo $id; ?>' ENCTYPE='multipart/form-data'>	
		<table style="text-align:left;" class="content">
			<tr>
				<th>Наименование:</th>
				<td><input type='text' name='name' value='<?=$row[0]['name']?>' size="79" required></td>
			</tr>
			<tr>
				<th>Категория:</th> 
				<td>				
					<select size="3" name="category">		
						<option value="Одежда" <?php if ($row[0]['category'] == "Одежда") echo "selected" ?>>Одежда</option>
						<option value="Аксессуары" <?php if ($row[0]['category'] == "Аксессуары") echo "selected" ?>>Аксессуары</option>
						<option value="Товары для интерьера" <?php if ($row[0]['category'] == "Товары для интерьера") echo "selected" ?>>Товары для интерьера</option>
					</select>
				</td>
			</tr>			 			
			<tr>
				<th>Цена:</th>
				<td><input type='number' name='price'  min="0" step="0.01" value='<?=$row[0]['price']?>' required>&nbsp;руб.</td>
			</tr>
			<tr>
				<th>Описание:</th>
				<td><textarea name='description' rows='10' cols='60' required><?=$row[0]['description']?></textarea>
			</tr>	
			<tr>
				<th>Изображение:</th>
				<td align="center"><input type="file" name="img" accept="image/jpeg"></td>
			</tr>			
			<rt>			
				<td colspan="2" align="right"><input type="submit" value="Сохранить" name="edit"></td>
			</tr>
		</table>			
	</form>
	<?php   
		if (isset($_POST['edit']))
		{ 
			if (!empty($_POST['name']) && !empty($_POST['category']) && !empty($_POST['price']) && !empty($_POST['description']))
			{	
				$img = $row[0]['image'];
				$name = clearData($_POST['name']);
				$category = clearData($_POST['category']);
				$price = clearData($_POST['price']);
				$description = clearData($_POST['description']);
				$cheak = getRecords("SELECT id FROM items WHERE name = '$name' and id<>'$id'");				
				if (count($cheak) == 0){
					if ($_FILES['img']['tmp_name'])
						$img = loadImage(); // грузим картинку
					if ($img != ""){
							doQuery("UPDATE items SET name = '$name', category = '$category', price = '$price', description = '$description', image ='$img' WHERE id = '$id'");								
							header("Location: index.php?page=catalog");
							exit;
					}
				}
				else
					echo '<font color="red">Зарись с таким наименование уже существует!</font>';	
			}
			else 
				echo '<font color="red">Заполните все поля!</font>';	
		}
	?>
</div>
