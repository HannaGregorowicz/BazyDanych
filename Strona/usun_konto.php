<?php

session_start();
if (!isset($_SESSION['zalogowano'])) {
	header('Location: logowanie.php');
	exit();
}


$title = "Usuwanie konta";
include 'baza.php';
$id_kl = $_SESSION['id_kl'];
$id_z = $_SESSION['id_z'];

require_once "polaczenie.php";
$link = new mysqli($host, $uzytkownik, $haslo_bazy, $nazwa_bazy);
if (!$link) die("Nie udało się połączyć.");
$q = "SELECT haslo FROM klient WHERE id_kl='$id_kl'";
$result = mysqli_query($link, $q) or die($link->error);
$row = $result->fetch_assoc();


if (isset($_POST['usuwanie'])) {
	$haslozbazy = $row['haslo'];
	$haslo = $_POST['haslo'];
	$haslo = md5($haslo);

	
	if ($haslo != $haslozbazy) {
		$_SESSION['blad_haslo'] = "Hasło jest nieprawidłowe";
	}
	else {
		$q1 = "DELETE FROM opinia WHERE kl_id='$id_kl'";
		$q2 = "DELETE szczegoly FROM szczegoly join zamowienie on z_id=id_z WHERE kl_id='$id_kl'";
		$q3 = "DELETE FROM zamowienie WHERE kl_id='$id_kl'";
		$q4 = "DELETE FROM klient WHERE id_kl='$id_kl'";
		mysqli_query($link, $q1) or die($link->error);
		mysqli_query($link, $q2) or die($link->error);
		mysqli_query($link, $q3) or die($link->error);
		mysqli_query($link, $q4) or die($link->error);
		
		session_unset();
		header('Location: index.php');
	}	
}
?>
<h2>Usuwanie konta</h2>

<form method="POST">
Wprowadź hasło, aby usunąć konto: <br>
	<input type="password" name="haslo"> <br><br>
	
	<?php 
		if (isset($_SESSION['blad_haslo'])) {
			echo '<div class="blad">'.$_SESSION['blad_haslo'].'</div>';
			unset($_SESSION['blad_haslo']);
		}	
	?>
	<input type="submit" value="Usuń konto" name="usuwanie">
</form>



<?php
$link->close();
include 'dol.php';
?>