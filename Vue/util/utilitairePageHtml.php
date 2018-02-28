<?php

class UtilitairePageHtml{

// Si user = encadrant
public function itemsBandeauApresConnexion()
{

    $info = pathinfo($_SERVER['PHP_SELF']);
  $menu='
    <body>
      <ul class="topnav" id="myTopnav">
        <li style="cursor:default"><a id="home" class="active" style="cursor:default" href="index.php"><img src="Vue/img/homeBleu.png" id="imgHome" style="cursor:pointer" onmouseout="mouseOutHome(this)" onmouseover="mouseOverHome(this)"></a></li>
        <li><a href="index.php?id=1">Consultation planning</a></li>
        <li><a href="index.php?id=2">Gestion disponibilités</a></li>
        <li><a href="index.php?id=3">Configuration</a></li>
        <li><a href="index.php?id=4">Passer en admin</a></li>
        <li><a id="deco" href="index.php?id=0">Déconnexion</a></li>
        <li class="icon"><a href="javascript:void(0);" style="font-size:15px;" onclick="onclickIcon(\'enc\')">☰</a></li>
      </ul>';
  return $menu;
}

// Si user = encadrant et admin
public function itemsBandeauApresConnexionEncAdmin()
{

    $info = pathinfo($_SERVER['PHP_SELF']);
  $menu='
    <body>
      <ul class="topnav" id="myTopnav">
        <li style="cursor:default"><a id="home" class="active" style="cursor:default" href="index.php"><img src="Vue/img/homeBleu.png" id="imgHome" style="cursor:pointer" onmouseout="mouseOutHome(this)" onmouseover="mouseOverHome(this)"></a></li>
        <li><a href="index.php?id=1">Consultation planning</a></li>
        <li><a href="index.php?id=2">Gestion disponibilités</a></li>
        <li><a href="index.php?id=3">Configuration</a></li>
        <li><a href="index.php?id=5">Passer en admin</a></li>
        <li><a id="deco" href="index.php?id=0">Déconnexion</a></li>
        <li class="icon"><a href="javascript:void(0);" style="font-size:15px;" onclick="onclickIcon(\'enc\')">☰</a></li>
      </ul>';
  return $menu;
}

// Si user = admin
public function itemsBandeauApresConnexionAdmin()
{

    $info = pathinfo($_SERVER['PHP_SELF']);

    $menu='
    <body>
      <ul class="topnavAdmin" id="myTopnavAdmin">
        <li style="cursor:default"><a id="homeAdmin" class="activeAdmin"  style="cursor:default" href="index.php"><img src="Vue/img/homeBleu.png" id="imgHome" style="cursor:pointer" onmouseout="mouseOutHome(this)" onmouseover="mouseOverHome(this)"></a></li>
        <li><a href="index.php?id=1">Gestion planning</a></li>
        <li><a href="index.php?id=2">Gestion des groupes</a></li>
        <li><a href="index.php?id=3">Gestion utilisateur</a></li>
        <li><a href="index.php?id=4">Gestion Configuration</a></li>
        <li><a href="index.php?id=5">Passer en Encadrant</a></li>
        <li><a id="decoAdmin" href="index.php?id=0">Déconnexion</a></li>
        <li class="iconAdmin"><a href="javascript:void(0);" style="font-size:15px;" onclick="onclickIcon(\'admin\')">☰</a></li>
      </ul>';
  return $menu;
}


/*
*Fonction qui génère l'entête de toutes nos pages HTML
*/
public function genereEnteteHtml(){
//header("Content-type: text/html; charset=utf-8");
$entete="<!DOCTYPE html>
<html>
  <head>
  <title>Gestion de planning</title>
    <meta charset=\"utf-8\" />
    <meta name=\"viewport\" content=\"width=device-width\"/>
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"/>
    <meta name=\"viewport\" content=\"width=device-width, minimum-scale=0.25\"/>
    <meta name=\"viewport\" content=\"width=device-width, maximum-scale=5.0\"/>
    <link href=\"Vue/css/style.css\" type=\"text/css\" rel=\"stylesheet\" />
    <link href=\"Vue/css/menu.css\" type=\"text/css\" rel=\"stylesheet\" />
    <script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js\"></script>
  </head>";

return $entete;
}



/*
*Fonction qui génère le pied de toutes nos pages HTML
*/
public function generePied(){
/*
onclickIcon(type): fonction qui gère le click sur le lien "icon" dans la navBar en fonction du type de l'utilisateur (encadrant/admin).
Ce lien est visible seulement après que la largeur de l'écran soit passé en dessous de 1000px
lors du clic, les elements de la nav bar s'affichent/disparraisent
*/

/*
mouseOverHome(elem), mouseOutHome(elem): elem, l'élement déclancheur de l'évenement
fonciton qui gère l'effet sur le bouton home:
lors du passage de la souris les couleurs du lien s'inversent
*/
$pied='
    <script>

      function onclickIcon(type){
        if(type == "enc"){
          var x = document.getElementById("myTopnav");
          if (x.className === "topnav"){
            x.className += " responsive";
          }
          else{
              x.className = "topnav";
          }
        }
        else{
          var x = document.getElementById("myTopnavAdmin");
          if (x.className === "topnavAdmin"){
            x.className += " responsive";
          }
          else{
            x.className = "topnavAdmin";
          }
        }
      }

      function mouseOverHome(elem){
        elem.src = "Vue/img/homeBlanc.png";
        elem.style.backgroundColor = "#6495ED";
        elem.style.borderRadius = "50%";
      }
      function mouseOutHome(elem){
        elem.src = "Vue/img/homeBleu.png";
        elem.style.backgroundColor = "white";
      }
    </script>
  </body>
  </html>';
return $pied;
}


}

?>
