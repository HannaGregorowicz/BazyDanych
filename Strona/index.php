<?php

$title = "BestBooks.pl";
include 'baza.php';

?>

<?php


require_once "polaczenie.php";

$link = new mysqli($host, $uzytkownik, $haslo_bazy, $nazwa_bazy);
if (!$link) die("Nie udało się połączyć.");
$q = "SELECT * FROM ksiazka WHERE id_ks>0 ORDER BY tytul";
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