<div class="index-text-1">Добавить товар </div>		
<div class="article">
	<form method='POST' action='index.php?page=add' ENCTYPE='multipart/form-data'>	
		<table style="text-align:left;" class="content">
			<tr>
				<th>Наименование:</th>
				<td><input type='text' name='name' size="79" required></td>
			</tr>
			<tr>
				<th>Категория:</th> 
				<td>				
					<select size="3" name="category">		
						<option value="Одежда" selected>Одежда</option>
						<option value="Аксессуары">Аксессуары</option>
						<option value="Товары для интерьера">Товары для интерьера</option>
					</select>
				</td>
			</tr>			 			
			<tr>
				<th>Цена:</th>
				<td><input type='number' name='price' min="0" step="0.01" required>&nbsp;руб.</td>
			</tr>
			<tr>
				<th>Описание:</th>
				<td><textarea name='description' rows='10' cols='60' required></textarea>
			</tr>	
			<tr>
				<th>Изображение:</th>
				<td align="center"><input type="file" name="img" accept="image/jpeg"></td>
			</tr>			
			<rt>			
				<td colspan="2" align="right"><input type="submit" value="Добавить товар" name="add"></td>
			</tr>
		</table>			
	</form>
	<?php   
		if (isset($_POST['add']))
		{ 
			if (!empty($_POST['name']) && !empty($_POST['category']) && !empty($_POST['price']) && !empty($_POST['description']))
			{	
				$img = "images/catalog/default";
				$name = clearData($_POST['name']);
				$category = clearData($_POST['category']);
				$price = clearData($_POST['price']);
				$description = clearData($_POST['description']);
				$cheack = getRecords("SELECT id FROM items WHERE name = '$name' ");	// проверяем нет ли товара с таким названием			
				if (count($cheack) == 0)
				{
					if ($_FILES['img']['tmp_name'])
						$img = loadImage(); // грузим картинку
					if ($img != ""){
						doQuery("INSERT INTO items (name,category,price,description,image) VALUES ('$name','$category','$price','$description','$img')");					
						
						header("Location: index.php?page=catalog");
						exit;
					}
				}
				else
					echo '<font color="red">Запись с таким название уже есть в таблице товаров!</font>';
			}
			else 
				echo '<font color="red">Заполните все поля!</font>';	
		}
	?>
</div>
