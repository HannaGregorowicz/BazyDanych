<?php

$title = "Wyszukiwanie";
include 'baza.php';

$szukanie = $_POST['search'];
echo $szukanie;
$szukanie = htmlentities($szukanie, ENT_QUOTES, "UTF-8");

require_once "polaczenie.php";
$link = new mysqli($host, $uzytkownik, $haslo_bazy, $nazwa_bazy);
if (!$link) die("Nie udało się połączyć.");

$result = mysqli_query($link, sprintf("SELECT * FROM ksiazka WHERE tytul like '%%%s%%' OR autor like '%%%s%%' ORDER BY tytul", 
mysqli_real_escape_string($link, $szukanie),
mysqli_real_escape_string($link, $szukanie))) or die($link->error);

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
			<td><?php echo "<a class=\"tytul\" href=\"detal.php?id_ks={$row['id_ks']}\">{$row['tytul']}</a>" ?></td>
			<td><?php echo $row['autor']; ?></td>
			<td><?php echo $row['cena']; ?></td>
			<td><?php echo $row['okladka']; ?></td>
			<td><?php echo $row['kategoria']; ?></td>
			<td><?php echo $row['wydawnictwo']; ?></td>
			<td><?php echo $row['rok_wydania']; ?></td>
			<td><?php echo "<a class=\"tytul\" href=\"usun_ksiazke.php?id_ks={$row['id_ks']}\">Usuń</a>" ?></td>
		</tr>
		<?php endwhile; ?>
	</table>
</div>


<?php
$link->close();
include 'dol.php';
?>