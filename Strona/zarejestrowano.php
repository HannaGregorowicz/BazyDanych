<?php
session_start();
if (!isset($_SESSION['zarejestrowano'])) {
	header('Location: index.php');
}
else {
	unset($_SESSION['zarejestrowano']);
}


if (isset($_SESSION['formularz_login'])) unset($_SESSION['formularz_login']);
if (isset($_SESSION['formularz_email'])) unset($_SESSION['formularz_email']);
if (isset($_SESSION['formularz_regulamin'])) unset($_SESSION['formularz_regulamin']);

if (isset($_SESSION['blad_login'])) unset($_SESSION['blad_login']);
if (isset($_SESSION['blad_email'])) unset($_SESSION['blad_email']);
if (isset($_SESSION['blad_haslo'])) unset($_SESSION['blad_haslo']);
if (isset($_SESSION['blad_regulamin'])) unset($_SESSION['blad_regulamin']);

$title = "Zarejestrowano!";
include 'baza.php';
?>

<p style="text-align:center; font-size:22px">Dziękujemy za rejestrację! Możesz się teraz zalogować.</p>
<p style="text-align:center"><a style="font-size:22px" href="logowanie.php">Zaloguj się!</a></p>


<?php
include 'dol.php';
?>