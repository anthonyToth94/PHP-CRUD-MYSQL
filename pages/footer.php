	</main>
	<aside>
		<div class="aside">
			<h3>Valami</h3>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat.</p>
		</div>

		<div class="aside">
			<h3>Programok</h3>
			<ul>
			<?php  

			//Elmentem az adatokat
			$li = ['Html','Css','JavaScript','Php','Bootstrap','Ajax','Jquery','C#','nodeJs','mysql','mongodb'];

			//Megírom az algoritmust
			foreach($li as $record){
				//Kirajzolom a képernyőre
				echo '<li>'.$record.'</li>';
			}

			?>
			</ul>
		</div>
	</aside>
	</div>	
	<footer>
		<nav>
			<ul>
				<?php nav(); ?>
			</ul>
		</nav>
	</footer>
</body>
</html>