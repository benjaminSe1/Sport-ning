<?php
  class vueGroupeEncadrant{

    public function afficherGroupes($planning){
      echo "<center></br><table>
            <tr><th>Groupe</th>
            <th>Supprimer</th></tr>";
        for ($j=1; $j <= sizeof($planning); $j++) {
            echo "<tr><form action=\"index.php?id=2 \" method=\"post\" ><td>".$planning[$j]['id']."</td><td><input type=\"hidden\"  name='id' value=".$planning[$j]['id']."><input type=\"submit\"  name='Supprimer' value='Supprimer'></input></td></form></tr>";
        }
        echo"";
        $this->ajoutGrp();
    		echo "</center>
        </body>";
      }

      public function afficherEncadrants($planning){
          echo "<center></br><table>
                <tr><th>Nom</th>
                <th>Prenom</th>
                <th>Telephone</th>
                <th>Adresse</th>
                <th>Login</th>
                <th>Mail</th>
                <th>Admin</th>
                <th>Actif</th>
                <th>Modifier</th></tr>";
          for ($i=1; $i <= sizeof($planning); $i++) {
                echo "<tr><form action=\"index.php?id=3 \" method=\"post\" ><td>".$planning[$i]['nom']."</td>"."<td>".$planning[$i]['prenom']."</td><td>".$planning[$i]['telephone']."</td><td>".$planning[$i]['adresse']."</td>
                <td>".$planning[$i]['login']."</td><td>".$planning[$i]['mail']."</td><td>".$planning[$i]['admin']."</td><td>".$planning[$i]['actif']."</td><td><input type=\"hidden\"  name='login' value=".$planning[$i]['login']."><input type=\"submit\" name='ModifierE' value='actif/inactif'></input></td></form></tr>";
          }
          echo"</table></br>";
          $this->ajoutEnc();
          "</body>";
        }

        public function ajoutGrp(){
          echo "<table><form action=\"index.php?id=2 \" method=\"post\" >
          <td><input type\"color\" name='couleur' value='#fad345'></input></td>
          <td><input type=\"submit\" name='ajoutGrp' value='Ajouter un Groupe'></input></td></form>
          </table>";
        }

        public function ajoutEnc(){
          echo "<center><table><tr><th>Ajout Encadrant</th> </tr>
      		<form action=\"index.php?id=3\" method=\"post\">
      		<table>
      		<tr><td> Prenom</td><td><input type=\"text\" name=\"prenom\"  /></td></tr>
      		<tr><td> Nom</td><td><input type=\"text\" name=\"nom\"  /></td></tr>
      		<tr><td> Telephone </td><td><input type=\"text\" name=\"telephone\"  /></td></tr>
      		<tr><td> Adresse </td><td><input type=\"text\" name=\"adresse\"  /></td></tr>
          <tr><td> Login </td><td><input type=\"text\" name=\"login\"  /></td></tr>
      		<tr><td> Mail </td><td><input type=\"email\" name=\"mail\"  /></td></tr>
          <tr><td> Admin </td><td><input type=\"radio\" name=\"admin\"  value=\"1\">Oui</input><input type=\"radio\" name=\"admin\"  value=\"0\">Non</input></td></tr>
      		<tr><td colspan=2><input type=\"submit\" name=\"AjoutEncadrant\" value=\"Ajouter\"/></td></tr>
          </center>
      		</form>
      		</table>";

        }
}

 ?>
