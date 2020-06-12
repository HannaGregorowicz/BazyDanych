<?php

session_start();
if (!isset($_SESSION['zalogowano'])) {
	header('Location: logowanie.php');
	exit();
}

$title = "Twoje zamówienia";
include 'baza.php';
$id_kl = $_SESSION['id_kl'];

require_once "polaczenie.php";
$link = new mysqli($host, $uzytkownik, $haslo_bazy, $nazwa_bazy);
if (!$link) die("Nie udało się połączyć.");
$q = "SELECT * FROM zamowienie WHERE status!='w trakcie' and kl_id='$id_kl' ORDER BY data";
$result = mysqli_query($link, $q) or die($link->error);

?>
<h2>Twoje zamówienia</h2>

<div>
	<table>
		
		<?php
			while ($row = $result->fetch_assoc()): ?>
		<tr>
			<td>Numer zamówienia: <?php echo $row['id_z']; ?></td>
			<td>Data złożenia: <?php echo $row['data']; ?>/5</td>
			<td>Status: <?php echo $row['status']; ?></td>
			<td><button>Opłać zamówienie</button>
		</tr>
		<?php endwhile; ?>
	</table>
</div>

<?php
$link->close();
include 'dol.php';
?>