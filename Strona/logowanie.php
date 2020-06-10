<?php
session_start();
if (isset($_SESSION['zalogowano']) && $_SESSION['zalogowano'] == true) {
	header('Location: profil.php');
	exit();
}

$title = "Logowanie";
include 'baza.php';
?>

<form action="zaloguj.php" method="POST">
Login: <br>
<input type="text" name="login"><br>

Hasło: <br>
<input type="password" name="haslo"><br>
<?php
if (isset($_SESSION['blad_logowania'])) {
	echo $_SESSION['blad_logowania']."<br>";
}
?>
<br>
<input type="submit" value="Zaloguj">
</form>
<br>




<br>
Nie masz jeszcze konta? <a href="rejestracja.php">Zarejestruj się!</a>

<?php
include 'dol.php';
?>