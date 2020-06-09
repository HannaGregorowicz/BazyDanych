<?php
session_start();
if (!isset($_SESSION['zalogowano'])) {
	header('Location: logowanie.php');
	exit();
}

$title = "BestBooks.pl";
include 'baza.php';

echo $_SESSION['user'];
?>



<?php
include 'dol.php';
?>