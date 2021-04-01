<?php 

//Elmentem az adatokat
$error = ""; 
$valueName = $valueEmail = $valueDate = "";
$categories = ["Weblap","Webshop","Foglalós"];
$error = false;

//Megírom az algoritmust
if(isset($_POST['submit'])){

	$name = trim($_POST['name']);
	$email = trim($_POST['email']);
	$category = $_POST['category'];
	$date = $_POST['date'];
	$time = $_POST['time'];

	switch($category){
		case 0: $category = $categories[0]; break;
		case 1: $category = $categories[1]; break;
		case 2: $category = $categories[2]; break;
	}

	if(empty($name) || empty($email)){
		$error = "Töltse ki a mezőket!";
	}
	else if(strlen($name) < 3){
		$error = "Legalább 3 karakter legyen a Név!";
	}
	else if(strlen($email) < 4){
		$error = "Legalább 4 karakter legyen az Email!";
	}
	if($error){
		$valueName = $name;
		$valueEmail = $email;
		$valueDate = $date;
	}else{

		$db = dbConnection();
		
		$query = $db->prepare("INSERT INTO users VALUES(NULL, :name, :email, :category, :tdate, :ttime)");
		$values = [
			'name' =>  $name,
			'email' =>  $email,
			'category' =>  $category,
			'tdate' =>  $date,
			'ttime' => $time,
		];
		$query->execute($values);

		$error = "Sikeres foglalás!";
	}

}

?>


<div class="regisztracio">
	<h2>Foglalas</h2>
	<form method="POST"	action=""> <!--Ha üres, akkor itt dolgozza fel! -->
		<div class="row"><span><?php echo $error ?></span></div> 

		<div class="row"><label for="inputName">Neve:</label>
		<input type="text" name="name" id="inputName" maxlength="50" value="<?= $valueName ?>"></div>

		<div class="row"><label for="inputEmail">E-mail címe:</label>
		<input type="email" name="email" id="inputEmail" maxlength="250" value="<?= $valueEmail ?>"></div>

		<div class="row"><label for="inputDate">Időpont:</label>
		<input type="date" name="date" id="inputDate" required value="<?= $valueDate ?>"></div>

		<div class="row"><label for="inputTime">Hány óra:</label>
		<select name="time" id="inputTime">
			<option value="8:00">8:00</option>
			<option value="10:00">10:00</option>
			<option value="12:00">12:00</option>
			<option value="14:00">14:00</option>
			<option value="16:00">16:00</option>
			<option value="18:00">18:00</option>
			<option value="20:00">20:00</option>
		</select></div>

		<div class="row"><label for="inputCategory">Szolgáltatás:</label>
		<select name="category" id="inputCategory">
			<option value="0">Weblap</option>
			<option value="1">Webshop</option>
			<option value="2">Foglalós</option>
		</select></div>

		<div class="row"><input type="submit" name="submit" id="submit" value="Küldés"></div>
	</form>
</div>