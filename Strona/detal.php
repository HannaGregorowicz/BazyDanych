<?php
session_start();

if (isset($_SESSION['id_kl'])) {
	$id_kl=$_SESSION['id_kl'];
}
else {
	$id_kl="Nie zalogowano";
}


$title = "BestBooks.pl";
include 'baza.php';

require_once "polaczenie.php";

$link = new mysqli($host, $uzytkownik, $haslo_bazy, $nazwa_bazy);
if (!$link) die("Nie udało się połączyć.");
$id_ks = $_GET['id_ks'];
$q = "SELECT * FROM ksiazka WHERE id_ks='$id_ks'";

$result = mysqli_query($link, $q) or die($link->error);
$row = $result->fetch_assoc();

echo "<h2>".$row['tytul']."</h2>";

if (isset($_GET['admin']) && $_GET['admin']=='true') {
	echo "<a class=\"tytul\" href=\"edytuj_ksiazke.php?id_ks={$id_ks}\">Edytuj</a>";
	echo "   ";
	echo "<a class=\"tytul\" href=\"usun_ksiazke.php?id_ks='$id_ks'\">Usuń</a>";
	
}

echo "<h3>".$row['autor']."</h3>";
echo "<h3>Cena: ".$row['cena']." zł</h3>";
echo "Wydawnictwo: ".$row['wydawnictwo']."<br>";
echo "Rok wydania: ".$row['rok_wydania']."<br>";
echo "Okładka: ".$row['okladka']."<br>";
echo "Kategoria: ".$row['kategoria']."<br>";
?>
<br>


<?php 

$q1 = "SELECT login, opinia.* FROM opinia join klient ON id_kl=kl_id WHERE ks_id={$_GET['id_ks']}";
$result1 = mysqli_query($link, $q1) or die($link->error);
$result2 = mysqli_query($link, $q1) or die($link->error);

$suma=0;
$ile_ocen=0;
while ($row2 = $result1->fetch_assoc()) :
	$suma = $suma+$row2['ocena'];
	$ile_ocen = $ile_ocen+1;
endwhile;
$srednia = $suma/$ile_ocen;

if ($ile_ocen>0) :
?>

<h3>Opinie</h3>
Średnia ocen: <?php echo $srednia; ?>/5<br>

<?php endif; ?>

<?php if (isset($_SESSION['zalogowano']) && $_SESSION['zalogowano'] == true) : ?>
<h4> Dodaj własną opinię!</h4>
<form method="POST" action="opinie.php?tr=dodaj&id_ks=<?php echo $id_ks?>">
	Ocena: <select name="ocena">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
	</select>
	Opinia:<br> <textarea rows="3" cols="130" name="opinia"></textarea><br>
	<input type="submit" value="Dodaj opinię" name="dodaj">
</form>
<?php endif; ?>

<div>
	<table>
		
		<?php
			while ($row1 = $result2->fetch_assoc()): ?>
		<tr>
			<td><?php echo $row1['login']; ?></td>
			<td>Ocena: <?php echo $row1['ocena']; ?>/5</td>
			<td><?php echo $row1['opis']; ?></td>
			<?php if ($id_kl==$row1['kl_id'] || $_GET['admin']=='true') :?>
			<td><form method="POST" action="opinie.php?tr=edytuj&id_o=<?php echo $row1['id_o'];?>&id_ks=<?php echo $id_ks?>&admin=true"><input type="submit" name="edytuj" value="Edytuj"></form></td>
			<td><form method="POST" action="opinie.php?tr=usun&id_o=<?php echo $row1['id_o'];?>&id_ks=<?php echo $id_ks?>&admin=true"><input type="submit" name="usun" value="Usuń"></form></td>
			<?php endif; ?>

		</tr>
		<?php endwhile; ?>
	</table>
</div>

<?php
$link->close();
include 'dol.php';
?>