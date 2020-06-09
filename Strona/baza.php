<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pl"><head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="style.css" type="text/css">
<title><?php echo $title; ?></title>
</head>
<body>
<div id="toolbar">
	<a href="index.php">Strona główna </a>
	<form action="szukaj.php" method="POST"> 
		<input type="text" name="search" value="Wpisz tytuł lub autora">
		<input type="submit" value="Szukaj">
	</form>
	<a href="koszyk.php">Twój koszyk </a>
	<a href="kontakt.php">Kontakt </a>
	<?php 
	if (isset($_SESSION['zalogowano']) && $_SESSION['zalogowano'] == true) {
		echo '<a href="profil.php">Profil </a>';
		echo '<a href="wyloguj.php">Wyloguj </a>';
}
	else {
		echo '<a href="rejestracja.php">Rejestracja </a>';
		echo '<a href="logowanie.php">Logowanie </a>';
}
	?>
</div>

<div id="main">