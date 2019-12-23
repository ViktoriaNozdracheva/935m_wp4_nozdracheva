<div class="article">
	<p style="text-align:center;">
		<b>
			Написать скрипт, определяющий возможность получения кредита пользователем в соответствии с введенными им данными
			и вычисляющий общую и месячную сумму к оплате. Учесть такие параметры, как ФИО, возраст пользователя, его заработную плату, 
			запрашиваюмую сумму, срок и процент по кредиту. Вывести всю информацию на экран.
		</b>
	</p>
	<br>
	<br>
	<div style="margin-left:125px;">
		<form  method='POST' action='index.php?page=lab3'>
			ФИО<br>
			<input type="text" name="fio" size="30"><br>
			Возраст<br>
			<input type="number" name="age" min="0" step="1"><br>
			Заработная плата<br>
			<input type="number" name="zp" min="0" step="1"><br>
			Сумма кредита<br>
			<input type="number" name="sum" min="0" step="1"><br>
			Срок(месяцев)<br>
			<input type="number" name="srok" min="1" step="1"><br>
			Процент по кредиту<br>
			<input type="number" name="proc" min="0" step="0.01"><br><br>	
			<input type="submit" value="Рассчитать" style="margin-left:40px;"><br>
		</form>
		<?php	
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				
				$fio = clearData($_POST['fio']);
				$age = clearData($_POST['age']);
				$zp = clearData($_POST['zp']);
				$sum = clearData($_POST['sum']);
				$srok = clearData($_POST['srok']);
				$proc = clearData($_POST['proc']);			
				if (!empty($fio) && !empty($age) && !empty($zp) && !empty($sum) && !empty($srok) && !empty($proc)){
					if ($age < 18 || $age >= 70)
						echo "<br><font color='red'>Не можем выдать кредит в связи с вашим возрастом!</font>";
					else{
						if ($zp < 20000)
							echo "<br><font color='red'>Не можем выдать кредит из-за маленкой ЗП!</font>";
						else{
							$P = $proc/1200; //Коэффициент процентной ставки						
							$A = $P * pow((1 + $P),$srok) / (pow((1 + $P),$srok) - 1); // Аннуитетный коэффициент 
							$Sa = round($A * $sum,2); // ежемесячный платеж
							$S = round($Sa * $srok,2); // общая сумма 
							echo "<br><br><table border='1' style='width:300px;'><tr><td><b>ФИО</b></td><td style='width:30%;'>".$fio."</td></tr>
								 <tr><td><b>Возраст</b></td><td>".$age."</td></tr>
								 <tr><td><b>ЗП</b></td><td>".$zp."</td></tr>
								 <tr><td><b>Сумма кредита</b></td><td>".$sum."</td></tr>
								 <tr><td><b>Срок(месяцев)</b></td><td>".$srok."</td></tr>
								 <tr><td><b>Ставка(% в год)</b></td><td>".$proc."</td></tr>
								 <tr><td><b>Ежемесячный платеж</b></td><td>".$Sa."</td></tr>
								 <tr><td><b>Общая сумма</b></td><td>".$S."</td></tr>
						 </table>";
						}
					}
				}
				else
					echo "<br><font color='red'>Заполните все поля!</font>";
			}
		?>
	</div>
</div>