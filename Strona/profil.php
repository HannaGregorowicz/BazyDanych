<?php
session_start();
if (!isset($_SESSION['zalogowano'])) {
	header('Location: logowanie.php');
	exit();
}

$title = "Twój profil";
include 'baza.php';

require_once "polaczenie.php";
$link = new mysqli($host, $uzytkownik, $haslo_bazy, $nazwa_bazy);
if (!$link) die("Nie udało się połączyć.");

$id_kl = $_SESSION['id_kl'];

$q = "SELECT * FROM klient WHERE id_kl='$id_kl'";
$result = mysqli_query($link, $q);

$klient = $result->fetch_assoc();
$login = $klient['login'];
$email = $klient['email'];
$imie = $klient['imie'];
$nazwisko = $klient['nazwisko'];
$miasto = $klient['miasto'];
$ulica = $klient['ulica'];
$nr_domu = $klient['nr_domu'];
$nr_lokalu = $klient['nr_lokalu'];
$kod_pocztowy = $klient['kod_pocztowy'];
?>
<h2>Twoje konto</h2>
<?php

//echo "Idz: ".$_SESSION['id_z']."<br>";

echo $login."<br>".$email."<br><br>";

if ($imie!="" && $nazwisko!="") {
	echo $imie." ".$nazwisko,"<br>";
	echo "<a href='dodaj_dane.php?dane=1'>Edytuj imię i nazwisko</a><br><br>";
	$_SESSION['imie'] = $imie;
	$_SESSION['nazwisko']= $nazwisko;
}
else {
	echo "<a href='dodaj_dane.php?dane=1'>Uzupełnij imie i nazwisko!</a><br>";
}

?>

<a href="zmiana_hasla.php"> Ustaw nowe hasło</a><br>
<br>
<?php

if ($miasto!="" && $kod_pocztowy!="" && $ulica!="" && $nr_domu!="") {
	echo $miasto." ".$kod_pocztowy."<br>".$ulica." ".$nr_domu;
	if ($nr_lokalu!="")
		echo "/".$nr_lokalu;
	echo "<br><a href='dodaj_dane.php?dane=2'>Edytuj adres</a><br>";
	$_SESSION['miasto']= $miasto;
	$_SESSION['kod_pocztowy']= $kod_pocztowy;
	$_SESSION['ulica']= $ulica;
	$_SESSION['nr_domu']= $nr_domu;
	$_SESSION['nr_lokalu']= $nr_lokalu;
}
else {
	echo "<a href='dodaj_dane.php?dane=2'>Uzupełnij adres!</a><br>";
}

?>
<br>
<a href="zamowienia.php">Twoje zamówienia</a><br><br>
<a href="usun_konto.php">Usuń konto</a>


<?php
include 'dol.php';
?>