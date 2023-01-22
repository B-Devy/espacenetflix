<?php
if(isset($_COOKIE['auth']) && !isset($_SESSION['connect'])){
    $secret = htmlspecialchars($_COOKIE['auth']);

    //  VERIFICATION
    require('database.php');

    $req = $database->prepare('SELECT count(*) as numberAccount from userflix WHERE secret = ?');
    $req->execute(array($secret));

    while($user = $req->fetch()){
        if($user['numberAccount'] == 1) {
            $reqUser = $database->prepare('SELECT * FROM userflix WHERE secret = ?');   // important de changer de variable ^req
            $reqUser->execute(array($secret));

            while($userAccount = $reqUser->fetch()) {
                $_SESSION['connect'] = 1;
                $_SESSION['email'] = $userAccount['email'];
            }
        }   
    }
    if(isset($_SESSION['connect'])){

		require('database.php');

		$reqUser = $db->prepare("SELECT * FROM userflix WHERE email = ?");
		$reqUser->execute(array($_SESSION['email']));

		while($userAccount = $reqUser->fetch()){

			if($userAccount['blocked'] == 1) {
				header('location: ../logout.php');
				exit();
			}

		}

	}
}   




?>