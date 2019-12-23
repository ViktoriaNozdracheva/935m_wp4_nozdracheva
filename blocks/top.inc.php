<div>
	<a href="index.php"><img class="index-main-img" src="images\logo.png" alt = "'логотип университета" ></a><br>			
</div>
<div class="index-text-2"> 
		<div>
			<?php
				if (!empty($_SESSION['login']))
					echo "<div id='auth'>Привет,<b style='color:black;'>".$_SESSION['login']."</b><a href='index.php?logout=true'>(Выход)</a></div>";
				?> 
		</div><br><br><br>
        <div> <b>Адрес:</b> г.Рязань, Гагарина, д.59/1</div>
		<div> <b>Телефон:</b> 8-900-955-50-55 </div>
		<div> <b>Email:</b> University@mail.ru </div>
</div>