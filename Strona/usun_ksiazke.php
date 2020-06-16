<?php

require_once "polaczenie.php";

$link = new mysqli($host, $uzytkownik, $haslo_bazy, $nazwa_bazy);
if (!$link) die("Nie udało się połączyć.");

$id_ks = $_GET['id_ks'];

$q = "DELETE FROM opinia WHERE ks_id='$id_ks'";
$q1 = "UPDATE szczegoly SET ks_id=0 WHERE ks_id='$id_ks'";
$q2 = "DELETE FROM ksiazka WHERE id_ks='$id_ks'";

mysqli_query($link, $q) or die($link->error);
mysqli_query($link, $q1) or die($link->error);
mysqli_query($link, $q2) or die($link->error);

$link->close();

header('Location: admin.php');
?>