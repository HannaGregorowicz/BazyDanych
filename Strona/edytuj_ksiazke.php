<?php
session_start();
if (!isset($_SESSION['zalogowano']) || $_SESSION['zalogowano'] == false) {
	header('Location: index.php');
}

require_once "polaczenie.php";

$link = new mysqli($host, $uzytkownik, $haslo_bazy, $nazwa_bazy);
if (!$link) die("Nie udało się połączyć.");

 

if (isset($_POST['submit'])) {
	$id_ks = $_GET['id_ks'];
	$tytul = $_POST['tytul'];
	$autor = $_POST['autor'];
	$cena = $_POST['cena'];
	$okladka = $_POST['okladka'];
	$kategoria = $_POST['kategoria'];
	$liczba = $_POST['liczba'];
	$wydawnictwo = $_POST['wydawnictwo'];
	$rok_wydania = $_POST['rok_wydania'];
	
	$q = "UPDATE ksiazka SET tytul='$tytul', autor='$autor', cena='$cena', okladka='$okladka', kategoria='$kategoria', liczba='$liczba', wydawnictwo='$wydawnictwo' WHERE id_ks='$id_ks'";
	
	mysqli_query($link, $q) or die($link->error);
	header('Location: index.php');
	
}
else {
	$id_ks = $_GET['id_ks'];
	$q = "SELECT * FROM ksiazka WHERE id_ks='$id_ks'";

	$result = mysqli_query($link, $q) or die($link->error);
	$ksiazka = $result->fetch_assoc();

	$tytul = $ksiazka['tytul'];
	$autor = $ksiazka['autor'];
	$cena = $ksiazka['cena'];
	$okladka = $ksiazka['okladka'];
	$kategoria = $ksiazka['kategoria'];
	$liczba = $ksiazka['liczba'];
	$wydawnictwo = $ksiazka['wydawnictwo'];
	$rok_wydania = $ksiazka['rok_wydania'];
}


include 'baza.php';
?>


<div id="nowa_ksiazka">
	<form method="POST">
		<input type="text" name="tytul" value="<?php echo $tytul;?>">
		<input type="text" name="autor" value="<?php echo $autor;?>">
		<input type="text" name="wydawnictwo" value="<?php echo $wydawnictwo;?>">
		Cena: <input type="number" name="cena" step="0.01" min="0" style="width: 70px;" value="<?php echo $cena;?>">
		Okładka: <select name="okladka">
			<option value="twarda" <?php if ($okladka=="twarda") echo "selected";?>>Twarda</option>
			<option value="miekka" <?php if ($okladka=="miekka") echo "selected";?>>Miękka</option>
		</select>
		Kategoria: <select name="kategoria">
			<option value="fantastyka" <?php if ($kategoria=="fantastyka") echo "selected";?>>Fantastyka</option>
			<option value="kryminal" <?php if ($kategoria=="kryminal") echo "selected";?>>Kryminał</option>
			<option value="horror" <?php if ($kategoria=="horror") echo "selected";?>>Horror</option>
			<option value="romans" <?php if ($kategoria=="romans") echo "selected";?>>Romans</option>
			<option value="nauka" <?php if ($kategoria=="nauka") echo "selected";?>>Nauka</option>
			<option value="kuchnia" <?php if ($kategoria=="kuchnia") echo "selected";?>>Kuchnia</option>
			<option value="obyczajowa" <?php if ($kategoria=="obyczajowa") echo "selected";?>>Obyczajowa</option>
			<option value="fakt" <?php if ($kategoria=="fakt") echo "selected";?>>Fakt</option>
			<option value="poradnik" <?php if ($kategoria=="poradnik") echo "selected";?>>Poradnik</option>
			<option value="biografia" <?php if ($kategoria=="biografia") echo "selected";?>>Biografia</option>
			<option value="dla dzieci" <?php if ($kategoria=="dla dzieci") echo "selected";?>>Dla dzieci</option>
			<option value="inna" <?php if ($kategoria=="inna") echo "selected";?>>Inna</option>
		</select>
		Liczba: <input type="number" name="liczba" min="0" style="width: 40px;" value="<?php echo $liczba;?>">
		Rok wydania: <input type="number" name="rok_wydania" min="1400" max="2021" value="<?php echo $rok_wydania;?>">
		<input type="submit" value="Edytuj" style="float: right" name='submit'>
	</form>
</div>
<br>


<?php 
include 'dol.php';

