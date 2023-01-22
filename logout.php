<?php
    session_start();
    session_unset(); // génére nouveau numéro de session
    session_destroy(); // supprime l'ancien numéro
    setcookie('auth', '', time() - 1, '/', null ,false, true);   //DETRUIT LE COOKIE

    header('location: index.php');
    exit();

?>