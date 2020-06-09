<?php

$title = "BestBooks.pl";
include 'baza.php';

require_once "polaczenie.php";

$link = new mysqli($host, $uzytkownik, $haslo_bazy, $nazwa_bazy);
if (!$link) die("Nie udało się połączyć.");
$q = "SELECT * FROM ksiazka WHERE id_ks={$_GET['id_ks']}";

$result = mysqli_query($link, $q) or die($link->error);
$row = $result->fetch_assoc();

echo $row['tytul'];
?>
<br>
Opinie

<?php 

$q1 = "SELECT login, opinia.* FROM opinia join klient ON id_kl=kl_id WHERE ks_id={$_GET['id_ks']}";
$result1 = mysqli_query($link, $q1) or die($link->error);

?>

<div>
	<table>
		<thead>
			<tr>
				<th>Klient</th>
				<th>Ocena</th>
				<th>Opis</th>
			</tr>
		</thead>
		
		<?php
			while ($row1 = $result1->fetch_assoc()): ?>
		<tr>
			<td><?php echo $row1['login']; ?></td>
			<td><?php echo $row1['ocena']; ?></td>
			<td><?php echo $row1['opis']; ?></td>

		</tr>
		<?php endwhile; ?>
	</table>
</div>

<?php
$link->close();
include 'dol.php';
?>