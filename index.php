<?php
require_once "Controleur/routeur.php";


session_start();

$routeur = new Routeur();

$routeur->routerRequete();
?>
