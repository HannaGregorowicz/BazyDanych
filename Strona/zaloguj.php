<?php
session_start();

if (!isset($_POST['login']) || !isset($_POST['haslo'])) {
	header('Location: logowanie.php');
	exit();
}

$login = $_POST['login'];
$haslo = $_POST['haslo'];
$haslo = md5($haslo); 

$login = htmlentities($login, ENT_QUOTES, "UTF-8");
$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");

require_once "polaczenie.php";
$link = new mysqli($host, $uzytkownik, $haslo_bazy, $nazwa_bazy);
if (!$link) die("Nie udało się połączyć.");
	

$result = mysqli_query($link, sprintf("SELECT * FROM klient WHERE BINARY login='%s' AND BINARY haslo='%s'", 
mysqli_real_escape_string($link, $login),
mysqli_real_escape_string($link, $haslo))) or die($link->error);

$ile_rekordow = $result->num_rows;
if ($ile_rekordow > 0) {
	$row = $result->fetch_assoc();
	$_SESSION['user'] = $row['login'];
	
	$_SESSION['zalogowano'] = true;
	$_SESSION['id'] = $row['id_kl'];
	
	unset($_SESSION['blad_logowania']);
	header('Location: profil.php');
}
else {
	$_SESSION['blad_logowania'] = '<span style="color:red">Błędny login lub hasło!</span>';
	header('Location: logowanie.php');
}

$link->close();

?>


