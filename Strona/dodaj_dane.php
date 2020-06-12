<?php
session_start();
if (!isset($_SESSION['zalogowano'])) {
	header('Location: logowanie.php');
	exit();
}

$title = "Uzupełnianie danych";
include 'baza.php';

require_once "polaczenie.php";
$link = new mysqli($host, $uzytkownik, $haslo_bazy, $nazwa_bazy);
if (!$link) die("Nie udało się połączyć.");

$id_kl = $_SESSION['id_kl'];

?>

<p style="font-size: 22px;">Uzupełnij dane:</p>

<?php

$ktore = $_GET['dane'];


if(isset($_POST['submit'])) {
	
	if ($ktore==1) {
		if ($_POST['imie']!="" && $_POST['nazwisko']!="") {
			$imie = $_POST['imie'];
			$nazwisko = $_POST['nazwisko'];
			$q = "UPDATE klient SET imie='$imie', nazwisko='$nazwisko' WHERE id_kl='$id_kl'";
			mysqli_query($link, $q) or die($link->error);
			header('Location: profil.php');
			exit();

		}
		else {
			echo "<p class='blad'>Nie uzupełniono wszystkich danych!</p><br>";
		}
	}
	else {
		
		if ($_POST['miasto']!="" && $_POST['kod_pocztowy']!="" && $_POST['ulica']!="" && $_POST['nr_domu']!="") {
			$miasto = $_POST['miasto'];
			$kod_pocztowy = $_POST['kod_pocztowy'];
			$ulica = $_POST['ulica'];
			$nr_domu = $_POST['nr_domu'];
			$nr_lokalu = $_POST['nr_lokalu'];
			$q = "UPDATE klient SET miasto='$miasto', kod_pocztowy='$kod_pocztowy', ulica='$ulica', nr_domu='$nr_domu', nr_lokalu='$nr_lokalu' WHERE id_kl='$id_kl'";
			mysqli_query($link, $q) or die($link->error);
			header('Location: profil.php');
			exit();

		}
		else {
			echo "<p class='blad'>Nie uzupełniono wszystkich danych!</p><br>";
		}
	}
}

if (!isset($ktore)) {
	header('Location: profil.php');
	exit();
}


if ($ktore==1) :
?>

<form method="POST">
	Imię: <br>
	<input type="text" name="imie" value=<?php echo $_SESSION['imie']; ?>><br>
	Nazwisko: <br>
	<input type="text" name="nazwisko" value=<?php echo $_SESSION['nazwisko']; ?>><br><br>
	<input type="submit" value="Gotowe!" name="submit">
</form>

<?php else : ?>

<form method="POST">
	Miasto: <br>
	<input type="text" name="miasto" value=<?php echo $_SESSION['miasto']; ?>><br>
	Ulica: <br>
	<input type="text" name="ulica" value=<?php echo $_SESSION['ulica']; ?>><br>
	Nr domu: <br>
	<input type="text" name="nr_domu" value=<?php echo $_SESSION['nr_domu']; ?>><br>
	Nr lokalu: <br>
	<input type="text" name="nr_lokalu" value=<?php echo $_SESSION['nr_lokalu']; ?>><br>
	Kod pocztowy: <br>
	<input type="text" name="kod_pocztowy" value=<?php echo $_SESSION['kod_pocztowy']; ?>><br><br>
	<input type="submit" value="Gotowe!" name="submit">
</form>


<?php
endif;

include 'dol.php';
?>