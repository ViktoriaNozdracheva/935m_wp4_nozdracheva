<?php
	if (isset($_POST['add'])) header("Location: index.php?page=add");
?>
<div class="index-text-1">Каталог</div>		
<div class="article">		
	<form action="index.php?page=catalog" method="POST">
		<input type="submit" name="add" value="Добавить">
		<input type="submit" name="del" value="Удалить">	
		<br><br>
		<?php	  
		if	(isset($_POST['del'])){	
			if (!empty($_POST['delId'])){			    
				foreach($_POST['delId'] as $val)
				{				
					doQuery("DELETE FROM items WHERE id = '$val'"); 
					@unlink('images/catalog/'.$val.'.jpg');			
				}
			}
			else echo "<font color='red'>Выберите записи для удаления!</font><br>";
		}
		?>		
		<br>
		<table class="content" >
			<tr>				
				<th>Фото</th>
				<th style="width:200px;">Категория</th>	
				<th style="width:500px;">Название</th>							
				<th>Цена</th>
				<th></th>
			</tr>			
			<?php
				$rows = getRecords("SELECT id,name,category,price,image FROM items ORDER BY id ASC");  // получаем все записи из таблицы items
				if (!empty($rows))
				{
					foreach($rows as $row)
					{
						echo "<tr>";
						echo "<td><img src='".$row['image'].".jpg"."' height='100' width='100'></td>";						
						echo "<td>".$row['category']."</td><td><a href='index.php?page=item&id=".$row['id']."'>".$row['name']."</a></td><td>".$row['price']."</td>";
						echo "<td width='10px'><input type='checkbox' name='delId[]' value=".$row['id']."></td>";
						echo "</tr>";
						
					}
				}
			?>
		</table>
</form>
</br>
</br>
</div>

