<?php

class vueUtilisateur {

		public function afficherPlanning($planning, $nb_grp, $nb_enc, $encRel) {
			echo "<center></br><table>
		    		<tr><th rowspan='2'>Date</th>
						<th colspan='".$nb_grp."'>Groupe</th>
						<th rowspan='2'>Commentaire</th>";
							var_dump($encRel);
						for ($e=1; $e <= $nb_enc; $e++) {
							if ($encRel[$encRel[$e]] == 0)
								echo "<th rowspan='2'>Encadrant ".$encRel[$e]."</th>";
						}
						echo "</tr><tr>";
						for ($g=1; $g <= $nb_grp; $g++) {
							echo "<th>Groupe ".$g."</th>";
						}
						echo "</tr>";
			for ($i=1; $i <= sizeof($planning); $i++) {
					echo "<tr><td>".$planning[$i]['date']."</td>";
					for ($gg=1; $gg <= $nb_grp; $gg++) {
						$grp = (isset($planning[$i]['grp'.$gg])) ? "X" : "";
						echo "<td>".$grp."</td>";
					}
					echo "<td>".$planning[$i]['commentaire']."</td>";
					for ($ee=1; $ee <= $nb_enc; $ee++) {
						if ($encRel[$encRel[$ee]] == 0) {
							$enc = (isset($planning[$i]['enc'.$ee])) ? "X" : "";
							echo "<td>".$enc."</td>";
						}
					}
					echo "</tr>";
			}
			echo "</table></br>
						<form action=\"index.php?id=1\" method=\"post\">
						<input type=\"submit\" name=\"ics\" value=\"Télécharger .ics\" />
						</form></center>";
		}

	public function afficherPlanningDispo($planning, $nb_grp, $id_enc) {
		echo "
		<center></br>
					<form action=\"index.php?id=2\" method=\"post\">
					<table>
					<tr><th rowspan='2'>Date</th>
					<th colspan='".$nb_grp."'>Groupe</th>
					<th rowspan='2'>Commentaire</th>
					<th rowspan='2'>Encadrant ".$_SESSION['login']."</th></tr><tr>";
					for ($g=1; $g <= $nb_grp; $g++) {
						echo "<th>Groupe ".$g."</th>";
					}
					echo "</tr>";
		for ($i=1; $i <= sizeof($planning); $i++) {
				echo "<tr><td>".$planning[$i]['date']."</td>";
				for ($gg=1; $gg <= $nb_grp; $gg++) {
					$grp = (isset($planning[$i]['grp'.$gg])) ? "X" : "";
					echo "<td>".$grp."</td>";
				}
				echo "<td>".$planning[$i]['commentaire']."</td>";
				$enc = (isset($planning[$i]['enc'.$id_enc['id']])) ? "<input type=\"checkbox\" name=\"dispo[]\" value=\"".$planning[$i]['id']."\" checked></br>Présent" : "<input type=\"checkbox\" name=\"dispo[]\" value=\"".$planning[$i]['id']."\"></br>Présent";
				echo "<td>".$enc."</td>";
				echo "</tr>";
			}
			echo "<input type=\"hidden\" name=\"date\" value=\"".$id_enc['id']."\"/>
						</table></br><input type=\"submit\" name=\"updtDispo\" value=\"Mettre à jour mes disponibilités\" /></form></center>";
	}


	//vue configuration
	public function AffichegestionConfig($info){

				echo "<form action=\"index.php?id=3\" method=\"post\" onsubmit=\"verifPasswd(this)\">";
					for ($i=1; $i <= sizeof($info); $i++) {
				echo	"<body background='Vue/img/arr.jpg'>
				<center></br><table>
							<tr>
								<td>Nom</td>
								<td> <input type=\"text\" name=\"nom\" value= \"".$info[$i]['nom']."\" /></td>
							</tr>
							<tr>
								<td>Prenom</td>
								<td><input type=\"text\" name=\"prenom\" value= \"".$info[$i]['prenom']."\" /> </td>
							</tr>
								";

							echo" <center></br>
							<tr>
								<td>Telephone</td>
								<td> <input type=\"text\" name=\"telephone\" value= \"".$info[$i]['telephone']."\" /></td>


							</tr>
							<tr>
								<td>Adresse</td>
								<td> <input type=\"text\" name=\"adresse\" value= \"".$info[$i]['adresse']."\"  /> </td>

							</tr>
							<tr>
								<td>Mail</td>
								<td> <input type=\"text\" name=\"mail\" value= \"".$info[$i]['mail']."\" 	/></td>
							</tr>



							</br>
							<tr>
								<td> Nouveau Mot de Passe</td>
								<td> <input type=\"password\" name=\"password1\" /></td>
							</tr>
							<tr>
								<td> Nouveau Mot de Passe</td>
								<td> <input type=\"password\" name=\"password2\" /></td>
							</tr>
							<tr>
							<td colspan='2' align='center'><input style='text-align:center' type=\"submit\" name=\"enregistrement\" value=\"Enregistrer\"/></td>
							</tr>
							</table>";

						}
				echo "
					<script>
					function verifPasswd(form){
						if (form.password1.value == '' || form.password2.value == '') {
						    alert('Tous les champs ne sont pas remplis');
						    form.password1.focus();
						    return false;
						}
						else if (form.password1.value != form.password2.value) {
							alert('Ce ne sont pas les mêmes mots de passe!');
						    form.password1.focus();
						    return false;
						}
						else if (form.password1.value == form.password2.value) {
						    return true;
						}
						else {
						    form.password1.focus();
						    return false;
						}
					}
					</script>";
				echo"</form></body>";

				}




} ?>
