<?php
session_start();
if (!isset($_SESSION['zalogowano'])) {
	header('Location: logowanie.php');
	exit();
}


$title = "Twój koszyk";
include 'baza.php';

require_once "polaczenie.php";
$link = new mysqli($host, $uzytkownik, $haslo_bazy, $nazwa_bazy);
if (!$link) die("Nie udało się połączyć.");

$id_kl = $_SESSION['id_kl'];
$id_z = $_SESSION['id_z'];

if (isset($_POST['usuwanie'])) {
	$id_ks = $_GET['id_ks'];
	$q1 = "DELETE FROM szczegoly WHERE z_id='$id_z' AND ks_id='$id_ks' LIMIT 1";
	mysqli_query($link, $q1) or die($link->error);
}

if (isset($_POST['zloz'])) {
	$q1 = "UPDATE zamowienie SET status='zlozone' WHERE id_z='$id_z'";
	mysqli_query($link, $q1) or die($link->error);
	unset($_SESSION['id_z']);
}


$q = "SELECT * FROM ksiazka JOIN szczegoly ON ks_id=id_ks WHERE id_ks>0 AND z_id='$id_z'";
$wynik = mysqli_query($link, $q) or die($link->error);


if ($wynik->num_rows==0) {
	echo "<h2 style='text-align: center'>Twój koszyk jest pusty</h2>";
}
else {
	echo "<h2>Twój koszyk: </h2>";
	echo "<table>";
	echo "<thead>";
		echo "<tr>";
			echo "<th>Tytuł</th>";
			echo "<th>Autor</th>";
			echo "<th>Cena</th>";
			echo "<th>Okładka</th>";
			echo "<th>Kategoria</th>";
			echo "<th>Wydawnictwo</th>";
			echo "<th>Rok wydania</th>";
		echo "</tr>";
	echo "</thead>";
	while ($row = $wynik->fetch_assoc()) {
		echo "<tr>";
			echo "<td><a href=\"detal.php?id_ks={$row['id_ks']}\">{$row['tytul']}</a></td>";
			echo "<td>".$row['autor']."</td>";
			echo "<td>".$row['cena']."</td>";
			echo "<td>".$row['okladka']."</td>";
			echo "<td>".$row['kategoria']."</td>";
			echo "<td>".$row['wydawnictwo']."</td>";
			echo "<td>".$row['rok_wydania']."</td>";
			echo "<td>Sztuk: ".$row['sztuk']."</td>";
			echo "<td><form method='POST' action='koszyk.php?id_ks=".$row['id_ks']."'><input type='submit' name='usuwanie' value='Usuń'></form></td>";
		echo "</tr>";
	}
	echo "</table>";	

echo "<form method='POST'>";
echo "<input type='submit' name='zloz' value='Złóż zamówienie!'>";
echo "</form>";
}


include 'dol.php';
?>