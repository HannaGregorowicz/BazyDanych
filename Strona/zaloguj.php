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
	$id_kl = $row['id_kl'];
	$_SESSION['id_kl'] = $id_kl;
	
	// --------- WAŻNE INFORMACJE ODNOŚNIE OBSŁUGI ZAMÓWIEŃ -------------
	// Założenie odnośnie zamówień. Użytkownik po zalogowaniu dostaje swój numer zamówienia (jeszcze przed "złożeniem" go). 
	// Ten numer jest pobrany z bazy po id klienta i statusie zamówienia "w trakcie". Jeśli nie ma takiego w bazie, tworzymy nowe zamówienie.
	// Dodawanie do koszyka pozycji będzie skutkowało wstawieniem nowych wierszy do tabeli "szczegóły" przypisanych do danego numeru zamówienia.
	// Po złożeniu zamówienia, jego status będzie się zmieniał na "złożone" i nie będzie można już dodawać do niego nowych pozycji.
	
	$szukanie_zamowienia = "SELECT id_z FROM zamowienie WHERE kl_id='$id_kl' AND status='w trakcie'";
	$wynik = mysqli_query($link, $szukanie_zamowienia) or die($link->error);

	
	if ($wynik->num_rows==0) {
		$nowe_zamowienie = "INSERT INTO zamowienie(kl_id) values ('$id_kl')";
		mysqli_query($link, $nowe_zamowienie) or die($link->error);
		$wynik = mysqli_query($link, $szukanie_zamowienia) or die($link->error);
	}

	$id_z = $wynik->fetch_assoc();
	$_SESSION['id_z'] = $id_z['id_z'];
	
	
	unset($_SESSION['blad_logowania']);
	header('Location: profil.php');
}
else {
	$_SESSION['blad_logowania'] = '<span style="color:red">Błędny login lub hasło!</span>';
	header('Location: logowanie.php');
}

$link->close();

?>


