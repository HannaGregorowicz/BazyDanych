<?php

$title = "Szczegoly zamowienia";
include 'baza.php';
$id_kl = $_SESSION['id_kl'];

$id_z = $_GET['id_z'];

require_once "polaczenie.php";
$link = new mysqli($host, $uzytkownik, $haslo_bazy, $nazwa_bazy);
if (!$link) die("Nie udało się połączyć.");

if (isset($_POST['status'])) {
	$status = $_POST['status'];
	$q = "UPDATE zamowienie SET status='$status' WHERE id_z='$id_z'";
	mysqli_query($link, $q) or die($link->error);
	header("Location: detal_zamowienia.php?id_z=$id_z&admin=true");
}

$q = "SELECT * FROM zamowienie join szczegoly on z_id=id_z join ksiazka on ks_id=id_ks join klient on kl_id=id_kl WHERE id_z='$id_z' ORDER BY id_ks DESC";
$result = mysqli_query($link, $q) or die($link->error);
$result1 = mysqli_query($link, $q) or die($link->error);
$row1 = $result1->fetch_assoc();

?>
<h3>Szczegóły</h3>

<div>
	<table>
		<tr>
			<td><b>Numer zamówienia:</b> <?php echo $id_z; ?></a></td>
			<td><b>Data złożenia:</b> <?php echo $row1['data']; ?></td>
			<td><b>Status:</b>
			<?php if ($_GET['admin']=='true') : ?>
			<td><form method="POST" action="detal_zamowienia.php?id_z=<?php echo $id_z; ?>&admin=true">
				<select name="status">
					<option value="zlozone" <?php if ($row1['status']=='zlozone') echo "selected";?>>Złożone</option>
					<option value="oplacone" <?php if ($row1['status']=='oplacone') echo "selected";?>>Opłacone</option>
					<option value="w realizacji" <?php if ($row1['status']=='w realizacji') echo "selected";?>>W realizacji</option>
					<option value="wyslane" <?php if ($row1['status']=='wyslane') echo "selected";?>>Wysłane</option>
					<option value="doreczone" <?php if ($row1['status']=='doreczone') echo "selected";?>>Doręczone</option>
					<option value="zwrot" <?php if ($row1['status']=='zwrot') echo "selected";?>>Zwrot</option>
				</select><input type="submit" name="submit" value="Edytuj status">
			</form></td>
			<?php else : echo $row1['status']; ?>
			<?php endif; ?>
		</tr>
		
		<?php if ($_GET['admin']=='true') : ?>
		<tr>
			<td><b>Klient:</b> <?php echo $row1['imie']." ".$row1['nazwisko'];?></td>
			<td><b>Adres:</b> <?php echo $row1['ulica']." ".$row1['nr_domu']."/".$row1['nr_lokalu'].", ".$row1['kod_pocztowy']." ".$row1['miasto']; ?></td>
		</td>
		<?php endif; ?>
		<tr><td><b>Zamówione książki:</td> </tr>
		<?php
			while ($row = $result->fetch_assoc()):
				if ($row['id_ks']=='0') :?>
				<tr>
					<td><?php echo $row['tytul'];?></td>
					<td>Sztuk: <?php echo $row['sztuk'];?></td>
				</tr>
				<?php else : ?>
			
				<tr>
					<td><?php echo "<a href=\"detal.php?id_ks={$row['id_ks']}\">{$row['tytul']}</a>" ?></td>
					<td><?php echo $row['autor']; ?></td>
					<td>Cena: <?php echo $row['cena']; ?></td>
					<td>Sztuk: <?php echo $row['sztuk']; ?></td>
				</tr>
				<?php endif; ?>
		<?php endwhile; ?>
	</table>
</div>

<?php
$link->close();
include 'dol.php';
?>