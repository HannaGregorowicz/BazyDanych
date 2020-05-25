<?php

$title = "BestBooks.pl";
include 'baza.php';

?>
<div id="nowa_ksiazka">
	<form action="dodaj_ksiazke.php" method="POST">
		<input type="text" name="tytul" value="Wpisz tytuł">
		<input type="text" name="autor" value="Wpisz autora">
		<input type="text" name="wydawnictwo" value="Wpisz wydawnictwo">
		Cena: <input type="number" name="cena" step="0.01" min="0" style="width: 70px;" value="0">
		Okładka: <select name="okladka">
			<option value="twarda">Twarda</option>
			<option value="miekka">Miękka</option>
		</select>
		Kategoria: <select name="kategoria">
			<option value="fantastyka">Fantastyka</option>
			<option value="kryminal">Kryminał</option>
			<option value="horror">Horror</option>
			<option value="romans">Romans</option>
			<option value="nauka">Nauka</option>
			<option value="kuchnia">Kuchnia</option>
			<option value="obyczajowa">Obyczajowa</option>
			<option value="fakt">Fakt</option>
			<option value="poradnik">Poradnik</option>
			<option value="biografia">Biografia</option>
			<option value="dla dzieci">Dla dzieci</option>
			<option value="inna">Inna</option>
		</select>
		Liczba: <input type="number" name="liczba" min="0" style="width: 40px;" value="0">
		Rok wydania: <input type="number" name="rok" min="1400" max="2021" value="2000">
		<input type="submit" value="Dodaj" style="float: right">
	</form>
</div>
<?php

$link = new mysqli("localhost", "hgregorowicz", "...", "hgregorowicz_baza_baza");
if (!$link) die("Nie udało się połączyć.");
$q = "SELECT tytul, autor, cena, okladka, kategoria, wydawnictwo, rok_wydania FROM ksiazka";
$result = mysqli_query($link, $q) or die($link->error);
//pre_r($result->fetch_assoc());
?>
<br><br>
<div>
	<table>
		<thead>
			<tr>
				<th>Tytuł</th>
				<th>Autor</th>
				<th>Cena</th>
				<th>Okładka</th>
				<th>Kategoria</th>
				<th>Wydawnictwo</th>
				<th>Rok wydania</th>
			</tr>
		</thead>
		
		<?php
			while ($row = $result->fetch_assoc()): ?>
		<tr>
			<td><?php echo $row['tytul']; ?></td>
			<td><?php echo $row['autor']; ?></td>
			<td><?php echo $row['cena']; ?></td>
			<td><?php echo $row['okladka']; ?></td>
			<td><?php echo $row['kategoria']; ?></td>
			<td><?php echo $row['wydawnictwo']; ?></td>
			<td><?php echo $row['rok_wydania']; ?></td>
		</tr>
		<?php endwhile; ?>
	</table>
</div>



<?php
function pre_r ($array) {
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

include 'dol.php';
?>