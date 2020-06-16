<?php

session_start();

$title = "Obsługa zamówień";
include 'baza.php';
//$id_kl = $_SESSION['id_kl'];

require_once "polaczenie.php";
$link = new mysqli($host, $uzytkownik, $haslo_bazy, $nazwa_bazy);
if (!$link) die("Nie udało się połączyć.");
$q = "SELECT * FROM zamowienie WHERE status!='w trakcie' ORDER BY data DESC";
$result = mysqli_query($link, $q) or die($link->error);

?>
<h2>Obsługa zamówień</h2>

<div>
	<table>
		
		<?php
			while ($row = $result->fetch_assoc()): ?>
		<tr>
			<td><a href="detal_zamowienia.php?id_z=<?php echo $row['id_z'];?>&admin=true">Numer zamówienia: <?php echo $row['id_z']; ?></a></td>
			<td>Data złożenia: <?php echo $row['data']; ?></td>
			<td>Status: <?php echo $row['status']; ?></td>
		</tr>
		<?php endwhile; ?>
	</table>
</div>

<?php
$link->close();
include 'dol.php';
?>