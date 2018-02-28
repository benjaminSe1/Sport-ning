<?php

class UtilitairePageHtml{

// Si user = encadrant
public function itemsBandeauApresConnexion()
{

	//$menu = "";
    $info = pathinfo($_SERVER['PHP_SELF']);

    $menu = "<body>\n";
    $menu .= "<div id=\"menu\">\n    <ul id=\"onglets\">\n";

    // Menu 1
    $menu .="<li class=\"onglets\"><a href=\"index.php?id=1\">Consultation planning</a></li>\n";

	// Menu 2
    $menu .="<li class=\"onglets\"><a href=\"index.php?id=2\">Gestion disponibilités</a></li>\n";

    // Menu 3
    $menu .="<li class=\"onglets\"><a href=\"index.php?id=3\"> Configuration</a></li>\n";


    // Déconnexion
    $menu .="<li class=\"de\"><a href=\"index.php?id=0\"> Déconnexion</a></li>\n";

    $menu .= "</ul>\n</div>";

        // on renvoie le code xHTML
        return $menu;
}

// Si user = admin
public function itemsBandeauApresConnexionAdmin()
{


    $info = pathinfo($_SERVER['PHP_SELF']);

    $menu = "<body>\n";
    $menu .= "<div id=\"menu\">\n    <ul id=\"onglets\">\n";

    // Menu 1
    $menu .="<li class=\"onglets\"><a href=\"index.php?id=1\">Gestion planning</a></li>\n";

    // Menu 2
    $menu .="<li class=\"onglets\"><a href=\"index.php?id=2\">Gestion des groupes</a></li>\n";

    // Menu 3
    $menu .="<li class=\"onglets\"><a href=\"index.php?id=3\">Gestions utilisateurs</a></li>\n";

    // Menu 4
    $menu .="<li class=\"onglets\"><a href=\"index.php?id=4\">Configuration</a></li>\n";




    // Déconnexion
    $menu .="<li class=\"de\"><a href=\"index.php?id=0\"> Déconnexion</a></li>\n";

    $menu .= "</ul>\n</div>";

        // on renvoie le code xHTML
        return $menu;
    }


public function genereEnteteHtml(){
//header("Content-type: text/html; charset=utf-8");
$entete="<!DOCTYPE html>";
$entete.="<html>";
$entete.="<head>";
$entete.="<meta charset=\"utf-8\" />";
$entete.="<title>Gestion de planning</title>";
$entete.= "<link href=\"Vue/css/menu.css\" type=\"text/css\" rel=\"stylesheet\" /> ";
$entete.="</head>";
return $entete;
}

public function genereBandeauApresConnexion(){
$entete=$this->genereEnteteHtml();
return $entete.$this->itemsBandeauApresConnexion();
}




public function generePied(){
$pied= "</body>";
$pied.= "</html>";
return $pied;
}


}

?>
