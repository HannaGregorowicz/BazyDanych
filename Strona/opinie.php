<?php
session_start();
if (!isset($_SESSION['zalogowano']) || $_SESSION['zalogowano'] == false) {
	header('Location: index.php');
}

include 'baza.php';

require_once "polaczenie.php";

$link = new mysqli($host, $uzytkownik, $haslo_bazy, $nazwa_bazy);
if (!$link) die("Nie udało się połączyć.");

$tryb = $_GET['tr'];
$id_ks = $_GET['id_ks'];
if ($tryb=='dodaj') {
	
	$id_kl = $_SESSION['id_kl'];
	$ocena = $_POST['ocena'];
	$opis = $_POST['opinia'];
	$q = "INSERT INTO opinia(ocena, opis, ks_id, kl_id) values ('$ocena', '$opis', '$id_ks', '$id_kl')";
	mysqli_query($link, $q) or die($link->error);
	header("Location: detal.php?id_ks=$id_ks");
}
else if ($tryb=='edytuj') {
	$id_o = $_GET['id_o'];
	$q = "SELECT * FROM opinia where id_o='$id_o'";
	$result = mysqli_query($link, $q) or die($link->error);
	$row = $result->fetch_assoc();
	$ocena = $row['ocena'];
	$opis = $row['opis'];
	
	?>
	<h4> Edytuj opinię</h4>
	<form method="POST" action="opinie.php?tr=edytuj1&id_o=<?php echo $id_o ?>&id_ks=<?php echo $id_ks?>">
		Ocena: <select name="ocena">
			<option value="1" <?php if ($ocena=="1") echo "selected";?>>1</option>
			<option value="2" <?php if ($ocena=="2") echo "selected";?>>2</option>
			<option value="3" <?php if ($ocena=="3") echo "selected";?>>3</option>
			<option value="4" <?php if ($ocena=="4") echo "selected";?>>4</option>
			<option value="5" <?php if ($ocena=="5") echo "selected";?>>5</option>
		</select>
		Opinia:<br> <textarea rows="3" cols="130" name="opinia"><?php echo $opis;?></textarea><br>
		<input type="submit" value="Edytuj opinię" name="edytuj">
	</form>
	
	<?php
	
}
else if ($tryb=='edytuj1') {
	$id_o = $_GET['id_o'];
	if (isset($_POST['edytuj'])) {
		$ocena = $_POST['ocena'];
		$opis = $_POST['opinia'];
		$q = "UPDATE opinia SET ocena='$ocena', opis='$opis' WHERE id_o='$id_o'";
		mysqli_query($link, $q) or die($link->error);
		header("Location: detal.php?id_ks=$id_ks");
	}
}

else if ($tryb=='usun') {
	$id_o = $_GET['id_o'];
	echo $id_o;
	echo $id_ks;
	$q = "DELETE FROM opinia WHERE id_o='$id_o'";
	mysqli_query($link, $q) or die($link->error);
	header("Location: detal.php?id_ks=$id_ks");
}
else
	echo "Błąd";


include 'dol.php';
?>
