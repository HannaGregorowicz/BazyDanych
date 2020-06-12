<?php

$title = "BestBooks.pl";
include 'baza.php';

?>

<?php if (isset($_SESSION['zalogowano']) && $_SESSION['zalogowano'] == true) : ?>
<div id="nowa_ksiazka">
	Dodaj książkę: <form action="dodaj_ksiazke.php" method="POST">
		<input type="text" name="tytul" value="Wpisz tytuł" style="width: 130px;">
		<input type="text" name="autor" value="Wpisz autora" style="width: 130px;">
		<input type="text" name="wydawnictwo" value="Wpisz wydawnictwo" style="width: 130px;">
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

<?php endif; ?>

<?php


require_once "polaczenie.php";

$link = new mysqli($host, $uzytkownik, $haslo_bazy, $nazwa_bazy);
if (!$link) die("Nie udało się połączyć.");
$q = "SELECT * FROM ksiazka ORDER BY tytul";
$result = mysqli_query($link, $q) or die($link->error);

?>
<h1>Wszystkie książki</h1>
<div>
	<table>
		<thead>
			<tr>
				<th>Tytuł</th>
				<th>Autor</th>
				<th>Cena</th>
			</tr>
		</thead>
		
		<?php
			while ($row = $result->fetch_assoc()): ?>
		<tr>
			<td><?php echo "<a href=\"detal.php?id_ks={$row['id_ks']}\">{$row['tytul']}</a>" ?></td>
			<td><?php echo $row['autor']; ?></td>
			<td><?php echo $row['cena']; ?></td>
			<!--<td><?php echo $row['okladka']; ?></td>
			<td><?php echo $row['kategoria']; ?></td>
			<td><?php echo $row['wydawnictwo']; ?></td>
			<td><?php echo $row['rok_wydania']; ?></td>-->
			
			<?php if (isset($_SESSION['zalogowano']) && $_SESSION['zalogowano'] == true) : ?>
			<td><?php echo "<a class=\"tytul\" href=\"edytuj_ksiazke.php?id_ks={$row['id_ks']}\">Edytuj</a>" ?></td>
			<td><?php echo "<a class=\"tytul\" href=\"usun_ksiazke.php?id_ks={$row['id_ks']}\">Usuń</a>" ?></td>
			
			<?php if ($row['liczba']>0) : ?>
			<td>Sztuk: <form method="POST" action="do_koszyka.php?id_ks=<?php echo $row['id_ks'];?>"><input type="number" style="width: 40px;" name="sztuk" min="0" value="1"><input type="submit" name="koszyk" value="Do koszyka"></form></td>
			<?php else : ?>
			<td>Brak książki na stanie.</td>
			<?php endif; ?>
			
			<?php endif; ?>
		</tr>
		<?php endwhile; ?>
	</table>
</div>



<?php

$link->close();

include 'dol.php';
?>