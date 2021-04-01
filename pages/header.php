<!DOCTYPE html>
<html>
<head>
	<title>Db Project</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
	<header>
		<div class="top">
		<?php
		 	//Elmentem az adatokat
			$ad = [
				[
					'title' => 'Random 1',
					'description' => 'Random 1 szovege reklam vagy barmi egyeb',
				],
				[
					'title' => 'Random 2',
					'description' => 'Random 2 szovege reklam vagy barmi egyeb',
				],
				[
					'title' => 'Random 3',
					'description' => 'Random 3 szovege reklam vagy barmi egyeb',
				]			
			];
			//Megírom az algoritmust
			$random = rand(0,2);
			$rnd = $ad[$random];

			//Kirajzolom a képernyőre
			echo '
				<h1>'.$rnd['title'].'</h1>
				<p>'.$rnd['description'].'</p>
			';
		?>

		</div>
		<nav>
			<ul>
				<?php nav(); ?>
			</ul>
		</nav>
	</header>
	<div class="container">
	<main>