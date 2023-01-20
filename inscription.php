<?php
session_start();



if(!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_two'])) {
	
	require('src/database.php');
	
	
	$email = htmlspecialchars($_POST['email']);
	$password = htmlspecialchars($_POST['password']);
	$password_two = htmlspecialchars($_POST['password_two']);
	
	// ADRESSE EMAIL SYNTAXE
	if($password != $password_two) {
		header('location: inscription.php?error=1&message=Vos mots de passe ne sont pas identiques');
		exit();
	}


	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		header('location: inscription.php?error=1&message=Votre adresse email est invalide.');
		exit();
	}


	$req = $database->prepare('SELECT count(*) as numberEmail FROM userflix WHERE email = ?');
	$req->execute(array($email));
	while($x = $req->fetch()) {
		if($x['numberEmail'] != 0) {
			header('location: inscription.php?error=1&message=Votre mail est déjà utilisé');
			exit();
		}
	}
/*-------------18:55
	$secret = "bibi" + sha1($password) + 313;

	$req = $database->prepare('INSERT INTO email, password, secret FROM userflix WHERE email = ?, password = ?, secret = ?');
	$req->execute(array($email, $password, $secret));

*/
	
}
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Netflix</title>
	<link rel="stylesheet" type="text/css" href="design/default.css">
	<link rel="icon" type="image/pngn" href="img/favicon.png">
</head>
<body>

	<?php include('src/header.php'); ?>
	
	<section>
		<div id="login-body">
			<h1>S'inscrire</h1>

			<?php
				if(isset($_GET['error'])) {
					if(isset($_GET['message'])) {
						echo '<div class="alert error">' .htmlspecialchars($_GET['message']). '</div>';
					}
				}
			?>

			<form method="post" action="inscription.php">
				<input type="email" name="email" placeholder="Votre adresse email" required />
				<input type="password" name="password" placeholder="Mot de passe" required />
				<input type="password" name="password_two" placeholder="Retapez votre mot de passe" required />
				<button type="submit">S'inscrire</button>
			</form>

			<p class="grey">Déjà sur Netflix ? <a href="index.php">Connectez-vous</a>.</p>
		</div>
	</section>

	<?php include('src/footer.php'); ?>
</body>
</html>