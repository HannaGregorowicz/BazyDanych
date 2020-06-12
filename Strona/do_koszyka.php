<?php
session_start();
require_once "polaczenie.php";

$link = new mysqli($host, $uzytkownik, $haslo_bazy, $nazwa_bazy);
if (!$link) die("Nie udało się połączyć.");

$id_ks = $_GET['id_ks'];
$sztuk = $_POST['sztuk'];
$z_id = $_SESSION['id_z']; 

$q = "INSERT INTO szczegoly(ks_id, z_id, sztuk) values ('$id_ks', '$z_id', '$sztuk')";

mysqli_query($link, $q) or die($link->error);

$link->close();

header('Location: index.php');
?>