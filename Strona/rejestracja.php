<?php
session_start();
if (isset($_SESSION['zalogowano']) && $_SESSION['zalogowano'] == true) {
	header('Location: profil.php');
	exit();
}

$title = "Rejestracja";

if (isset($_POST['login'])) {
	$czyWszystkoUdane = true;
	
	$login = $_POST['login'];	
	if (strlen($login)<3 || strlen($login)>30) {		// Sprawdzenie ilosci znaków
		$czyWszystkoUdane = false;
		$_SESSION['blad_login'] = "Login musi posiadać od 3 do 30 znaków!";
	}
	
	if (!ctype_alnum($login)) {		// Sprawdzenie znaków
		$czyWszystkoUdane = false;
		$_SESSION['blad_login'] = "Login może zawierać tylko litery (bez polskich znaków) i cyfry!";
	}
	
	$email = $_POST['email'];
	$email1 = filter_var($email, FILTER_SANITIZE_EMAIL);
	
	if (!filter_var($email, FILTER_VALIDATE_EMAIL) || ($email != $email1)) {		// Sprawdzenie poprawności maila
		$czyWszystkoUdane = false;
		$_SESSION['blad_email'] = "Niepoprawny adres e-mail!";
	}
	
	$haslo1 = $_POST['haslo1'];
	$haslo2 = $_POST['haslo2'];
	
	if (strlen($haslo1)<8 || strlen($haslo1)>45) {		// Sprawdzenie długości haseł
		$czyWszystkoUdane = false;
		$_SESSION['blad_haslo'] = "Hasło musi zawierać od 8 do 45 znaków!";
	}
	
	if ($haslo1 != $haslo2) {		// Sprawdzenie czy hasła są takie same
		$czyWszystkoUdane = false;
		$_SESSION['blad_haslo'] = "Hasła nie są takie same!";
	}
	
	if (!isset($_POST['regulamin'])) {		// Sprawdzenie czy regulamin zaakceptowany
		$czyWszystkoUdane = false;
		$_SESSION['blad_regulamin'] = "Nie zaakceptowano regulaminu!";
	}
	
	
	$_SESSION['formularz_login'] = $login;
	$_SESSION['formularz_email'] = $email;
	if (isset($_POST['regulamin'])) 
		$_SESSION['formularz_regulamin'] = true;
	
	
	
	require_once "polaczenie.php";
	$link = new mysqli($host, $uzytkownik, $haslo_bazy, $nazwa_bazy);
	if (!$link) die("Nie udało się połączyć.");
	$q = "SELECT id_kl FROM klient WHERE email='$email'";
	$result = mysqli_query($link, $q) or die($link->error);
		
	$ile_maili = $result->num_rows;
	if ($ile_maili>0) {			// Sprawdzenie czy istnieje taki email w bazie
		$czyWszystkoUdane = false;
		$_SESSION['blad_email'] = "Istnieje już konto przypisane do tego adresu e-mail!";
	}
	
	$q1 = "SELECT id_kl FROM klient WHERE login='$login'";
	$result1 = mysqli_query($link, $q1) or die($link->error);
		
	$ile_loginow = $result1->num_rows;
	if ($ile_loginow>0) {		// Sprawdzenie czy istnieje taki użytkownik w bazie
		$czyWszystkoUdane = false;
		$_SESSION['blad_login'] = "Istnieje już taki użytkownik!";
	}
		

	if ($czyWszystkoUdane) {
		$haslo1 = md5($haslo1);
		
		$wstaw = "INSERT INTO klient (login, haslo, email) VALUES ('$login', '$haslo1', '$email')";
		if ($link->query($wstaw)) {
			$_SESSION['zarejestrowano'] = true;
			header('Location: zarejestrowano.php');
		}
	}
	
}

include 'baza.php';
?>

REJESTRACJA <br><br>

<form method="POST">
	Login: <br>
	<input type="text" name="login" value="<?php 
		if (isset($_SESSION['formularz_login'])) {
			echo $_SESSION['formularz_login'];
			unset ($_SESSION['formularz_login']);
		}
	?>"><br>
	<?php 
		if (isset($_SESSION['blad_login'])) {
			echo '<div class="blad">'.$_SESSION['blad_login'].'</div>';
			unset($_SESSION['blad_login']);
		}	
	?>
	
	E-mail: <br>
	<input type="text" name="email" value="<?php 
		if (isset($_SESSION['formularz_email'])) {
			echo $_SESSION['formularz_email'];
			unset ($_SESSION['formularz_email']);
		}
	?>"><br>
	<?php 
		if (isset($_SESSION['blad_email'])) {
			echo '<div class="blad">'.$_SESSION['blad_email'].'</div>';
			unset($_SESSION['blad_email']);
		}	
	?>
	Hasło: <br>
	<input type="password" name="haslo1"><br>
	<?php 
		if (isset($_SESSION['blad_haslo'])) {
			echo '<div class="blad">'.$_SESSION['blad_haslo'].'</div>';
			unset($_SESSION['blad_haslo']);
		}	
	?>
	Powtórz hasło: <br>
	<input type="password" name="haslo2"><br>
	<input type="checkbox" name="regulamin" <?php 
		if (isset($_SESSION['formularz_regulamin'])) {
			echo "checked";
			unset($_SESSION['formularz_regulamin']);
		}
	?>/> Akceptuję regulamin <br>
	<?php 
		if (isset($_SESSION['blad_regulamin'])) {
			echo '<div class="blad">'.$_SESSION['blad_regulamin'].'</div>';
			unset($_SESSION['blad_regulamin']);
		}	
	?>
	<br><input type="submit" value="Zarejestruj się">
</form>
<br><br>
Masz już konto? <a href="logowanie.php">Zaloguj się!</a>

<?php
include 'dol.php';
?>