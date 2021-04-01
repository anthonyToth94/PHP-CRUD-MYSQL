<?php 

//Behívom a hivatkozni kívánt elemeket
include('functions/functions.php'); 

//Dinamikus fejléc
include('pages/header.php');
		
	//get=page paraméter vizsgálása
	$page = "home";

	if(isset($_GET['page'])){
		$page = $_GET['page'];
	}

	switch($page){
		case 'home': include('pages/page-home.php'); break;
		case 'regisztracio': include('pages/page-regisztracio.php'); break;
		case 'bejelentkezes': include('pages/page-bejelentkezes.php'); break;
		default: echo '<h2>Ilyen oldal nincs</h2>'; break;
	}

//Dinamikus lábléc
include('pages/footer.php');

?>