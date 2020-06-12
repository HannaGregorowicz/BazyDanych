<?php

session_start();
if (!isset($_SESSION['zalogowano'])) {
	header('Location: logowanie.php');
	exit();
}


$title = "Zmiana hasła";
include 'baza.php';
$id_kl = $_SESSION['id_kl'];


require_once "polaczenie.php";
$link = new mysqli($host, $uzytkownik, $haslo_bazy, $nazwa_bazy);
if (!$link) die("Nie udało się połączyć.");
$q = "SELECT haslo FROM klient WHERE id_kl='$id_kl'";
$result = mysqli_query($link, $q) or die($link->error);
$row = $result->fetch_assoc();

$udalo_sie=true;

if (isset($_POST['haslo'])) {
	$starehaslo = $row['haslo'];
	$starehaslo1 = $_POST['starehaslo1'];
	$starehaslo1 = md5($starehaslo1);
	$haslo1 = $_POST['haslo1'];
	$haslo2 = $_POST['haslo2'];
	
	if (strlen($haslo1)<8 || strlen($haslo1)>45) {
		$udalo_sie = false;
		$_SESSION['blad_haslo'] = "Hasło musi zawierać od 8 do 45 znaków!";
	}
	
	if ($haslo1 != $haslo2) {
		$udalo_sie = false;
		$_SESSION['blad_haslo'] = "Hasła nie są takie same!";
	}
	
	if ($starehaslo != $starehaslo1) {
		$udalo_sie = false;
		$_SESSION['blad_haslo'] = "Stare hasło jest nieprawidłowe";
	}
	
	if ($udalo_sie) {
		$haslo1 = md5($haslo1);
		
		$wstaw = "UPDATE klient SET haslo='$haslo1'";
		if ($link->query($wstaw)) {
			header('Location: profil.php');
		}
	}
	
}

?>
<h2>Zmiana hasła</h2>

<form method="POST">
Wprowadź obecne hasło: <br>
	<input type="password" name="starehaslo1"> <br><br>
	
Wprowadź nowe hasło: <br>
	<input type="password" name="haslo1"> <br><br>
	
Potwierdź nowe hasło: <br>
	<input type="password" name="haslo2"> <br><br>
	<?php 
		if (isset($_SESSION['blad_haslo'])) {
			echo '<div class="blad">'.$_SESSION['blad_haslo'].'</div>';
			unset($_SESSION['blad_haslo']);
		}	
	?>
	<input type="submit" value="Zmień hasło" name="haslo">
</form>



<?php
$link->close();
include 'dol.php';
?>