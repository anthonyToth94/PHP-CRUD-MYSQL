<?php

session_start();

//Elmentem az adatokat
$login = false;
$error = "";
$valueName = $valuePassword = "";
$error = false;
$errors = ["<h1>Előszőr be kell jelentkeznie!</h1>","<h1>Ilyen azonosító nem található!</h1>"];

//Megírom az algoritmust CREATE TETEJÉRE MERT MÉG NINCS KIRAJZOLVA
if(isset($_POST['submit'])){
	
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
		
	if(empty($username) || empty($password)){
		$error = "Töltse ki a mezőket!";
	}
	else
	{
		$db = dbConnection();

		$query = $db->prepare("SELECT * FROM admin WHERE username = :uname AND password = :password");
		$values =[
			'uname' => $username,
			'password' => $password,
		];
		$query->execute($values);

		$result = $query->fetch( PDO::FETCH_ASSOC );

		if($result){
			//Beléptél
			$login = true;

			if(!isset($_SESSION['login'])){
	
				$_SESSION['login'] = $login; //login true tárolva
			}


		}else{
			$error = "Hibás felhasználó vagy jelszó!";
		}
	
	}

	if($error){
		$valueName = $username;
		$valuePassword = $password;
	}

}

if(!isset($_SESSION['login']) && !isset($_GET['azonosito']) && !isset($_GET['kilepes']) && !isset($_GET['delete']) ) {?>

<div class="bejelentkezes">
	<h2>Bejelentkezes </h2>
	<form method="POST"	action=""> <!--Ha üres, akkor itt dolgozza fel! -->
		<div class="row"><span><?php echo $error ?></span></div> 

		<div class="row"><label for="inputName">Felhasználó:</label>
		<input type="text" name="username" id="inputName" maxlength="50" value="<?= $valueName ?>"></div>

		<div class="row"><label for="inputPassword">Jelszo:</label>
		<input type="text" name="password" id="inputPassword" maxlength="50" value="<?= $valuePassword ?>"></div>

		<div class="row"><input type="submit" name="submit" class="submit" value="Küldés"></div>
	</form>
</div>

<?php } //Kirajzolom a kimenetet
else if(!isset($_SESSION['login']) && isset($_GET['azonosito']) && !isset($_GET['kilepes']) && !isset($_GET['delete']) )
{
	echo $errors[0];
}
else if(!isset($_SESSION['login']) && !isset($_GET['azonosito']) && !isset($_GET['kilepes']) && isset($_GET['delete']) )
{
	echo $errors[0];
}
else if(isset($_SESSION['login']) && !isset($_GET['azonosito']) && !isset($_GET['kilepes']) && !isset($_GET['delete']) )
{
	echo '<table>
			<tr>
				<th>Id</th>
				<th>Rendelő</th>	
				<th>E-mail</th>
				<th>Kategória</th>
				<th>Dátum</th>
				<th>Idő</th>
				<th>Kiválaszt</th>
				<th>Törlés</th>
			</tr>';

	$db = dbConnection();
	$query = $db->query("SELECT * FROM users");
	$results = $query->fetchAll( PDO::FETCH_NUM );
	
	foreach($results as $sor)
	{

		$id = $sor[0];
		$rendelo = $sor[1];
		$email = $sor[2];
		$kategoria = $sor[3];
		$datum = $sor[4];
		$ido = $sor[5];

		echo '<tr>
				<td>'.$id.'</td>
				<td>'.$rendelo.'</td>
				<td>'.$email.'</td>
				<td>'.$kategoria.'</td>
				<td>'.$datum.'</td>
				<td>'.$ido.'</td>
				<td><a href="index.php?page=bejelentkezes&azonosito='.$id.'" class="kivalaszt">Kiválaszt</a></td>
				<td><a href="index.php?page=bejelentkezes&delete='.$id.'" class="torles">Törlés</a></td>
			</tr>';
	}

	echo '</table>';

	echo '<button><a href="index.php?page=bejelentkezes&kilepes=1" id="logout">logout</a></button>';
}
else if(isset($_SESSION['login']) && isset($_GET['azonosito']) && !isset($_GET['kilepes']) && !isset($_GET['delete']) )
{
	$azonosito = $_GET['azonosito'];
	
	$result = getById($azonosito);

	if($result){
		$id = $result['id'];
		$name = $result['name'];
		$email = $result['email'];
		$category = $result['category'];
		$date = $result['date'];
		$time = $result['time'];

		var_dump($result['date']);
		var_dump($result['time']);
		echo '
		<div class="frissites">
			<h2>Frissites</h2>
			<form method="POST"	action=""> <!--Ha üres, akkor itt dolgozza fel! --> 
				<div class="row">
				<input type="number" name="id" value="'.$id.'"></div>

				<div class="row">
				<input type="text" name="name" value="'.$name.'"></div>

				<div class="row">
				<input type="email" name="email" value="'.$email.'"></div>

				<div class="row">
				<input type="date" name="date" value="'.$date.'"></div>

				<div class="row">
				<select name="time" id="time">
					<option style="background:green" value="'.$time.'">'.$time.'</option>
					<option value="8:00">8:00</option>
					<option value="10:00">10:00</option>
					<option value="12:00">12:00</option>
					<option value="14:00">14:00</option>
					<option value="16:00">16:00</option>
					<option value="18:00">18:00</option>
					<option value="20:00">20:00</option>
				</select></div>

				<div class="row">
				<select name="category">
					<option style="background:green" value="'.$category.'">'.$category.'</option>
					<option value="0">Weblap</option>
					<option value="1">Webshop</option>
					<option value="2">Foglalós</option>
				</select></div>

				<div class="row"><input type="submit" name="update" value="Frissites" class="submit"></div>
			</form>
			<button stlye="margin-top:10px;"><a id="back" href="index.php?page=bejelentkezes">Vissza</a></button>
		</div> ';

	}
	else
	{
		echo $errors[1];
	}

}
else if(isset($_SESSION['login']) && !isset($_GET['azonosito']) && !isset($_GET['kilepes']) && isset($_GET['delete']) )
{
	$getId = $_GET['delete'];

	$result = getById($getId);

	if($result)
	{
		$db = dbConnection();
		$query = $db->prepare("DELETE FROM users WHERE id = :id");
		$value = [ "id" => $getId ];
		$query->execute($value);

		header("location:http://localhost/dbCreateReadUpdateDeleteProjectInPhp/index.php?page=bejelentkezes");
	}
	else
	{
		echo $errors[1];
	}	
}
else if(isset($_SESSION['login']) && !isset($_GET['azonosito']) && isset($_GET['kilepes']) && !isset($_GET['delete']) )
{
	unset($_SESSION['login']);
	header("location:http://localhost/dbCreateReadUpdateDeleteProjectInPhp/index.php?page=bejelentkezes");
}
else{
	//echo '<h1>Ilyen oldal nem található</h1>';
}


//Megírom az algoritmust UPDATE ALJÁRA MERT MÉG A TETEJÉN NINCS KIRAJZOLVA
if(isset($_POST['update'])){
	$categories = ["Weblap","Webshop","Foglalós"];

	$id = $_POST['id'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$category = $_POST['category'];
	$date = $_POST['date'];
	$time = $_POST['time'];

		switch($category){
		case 0: $category = $categories[0]; break;
		case 1: $category = $categories[1]; break;
		case 2: $category = $categories[2]; break;
	}

	$db = dbConnection();
	$query = $db->prepare("UPDATE users SET name = :name, email = :email, category = :category, date = :tdate, time = :ttime WHERE id = :id");
	$values = [
		"name"=> $name,
		"email"=> $email,
		"category"=> $category,
		"tdate"=> $date,
		"ttime"=> $time,
		"id"=> $id,
	];
	$query->execute($values);

	header("location:http://localhost/dbCreateReadUpdateDeleteProjectInPhp/index.php?page=bejelentkezes");
}



function getById($id){
	$db = dbConnection();
	$query = $db->prepare("SELECT * FROM users WHERE id = :id");
	$value = [
		"id"=> $id
	];
	$query->execute($value);
	return $result = $query->fetch( PDO::FETCH_ASSOC );
}

?>







