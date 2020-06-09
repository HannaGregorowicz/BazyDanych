<?php
session_start();
if (isset($_SESSION['zalogowano']) && $_SESSION['zalogowano'] == true) {
	header('Location: profil.php');
	exit();
}

$title = "BestBooks.pl";
include 'baza.php';
?>

<form action="zaloguj.php" method="POST">
Login: <br>
<input type="text" name="login"><br>

Hasło: <br>
<input type="password" name="haslo"><br><br>
<input type="submit" value="Zaloguj">
</form>

<?php
if (isset($_SESSION['blad_logowania'])) {
	echo $_SESSION['blad_logowania'];
}
include 'dol.php';
?>