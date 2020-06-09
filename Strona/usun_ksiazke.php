<?php

require_once "polaczenie.php";

$link = new mysqli($host, $uzytkownik, $haslo_bazy, $nazwa_bazy);
if (!$link) die("Nie udało się połączyć.");
$q = "DELETE FROM ksiazka WHERE id_ks={$_GET['id_ks']}";

mysqli_query($link, $q) or die($link->error);

$link->close();

header('Location: index.php');
?>