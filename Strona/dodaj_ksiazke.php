<?php

$czy_wypelnione = true;

foreach($_POST as $check => $val) {
	if (empty($_POST[$check])) {
		$czy_wypelnione = false;
		break;
	}
}	

if ($czy_wypelnione) {
	$tytul = $_POST['tytul'];
	$autor = $_POST['autor'];
	$wydawnictwo = $_POST['wydawnictwo'];
	$cena = $_POST['cena'];
	$okladka = $_POST['okladka'];
	$kategoria = $_POST['kategoria'];
	$liczba = $_POST['liczba'];
	$rok_wydania = $_POST['rok'];
	
	$link = new mysqli("localhost", "hgregorowicz", "...", "hgregorowicz_baza_baza");
	if (!$link) die("Nie udało się połączyć.");
	$q = "INSERT INTO ksiazka (tytul, autor, cena, okladka, kategoria, liczba, wydawnictwo, rok_wydania) VALUES ('$tytul', '$autor', $cena, '$okladka', '$kategoria', $liczba, '$wydawnictwo', $rok_wydania)";
	$result = mysqli_query($link, $q) or die($link->error);
}
?>

