<?php
class vueAdministrateur {

		public function afficherPlanning($planning, $nb_grp) {
			echo"<!DOCTYPE HTML>
		        <html>
		        <head>
		        <title>Calendrier</title>
		        <meta http-equiv=\"Content-Type\" content=\"text/html\"; charset=\"utf-8\" />
		        <style>
		          td {
		            border: 1px solid #456B99;
		            width: 70px;
		            text-align: center;
		          }
		        </style>
		        </head>
		        <body>";
			if (isset($_POST['valider'])) {
			  $mm = explode("-", $_POST['date_faite'])[1];
			  if (substr($mm, 0, 1) == 0) {
			    $m = substr(explode("-", $_POST['date_faite'])[1], 1);
			  } else {
			    $m == $mm;
			  }
			} else {
			  $m = (isset($_POST['m'])) ? $_POST['m'] : date("n");
			}
			$a = date("Y");
			$dayone = date("w",mktime(1,1,1,$m,1,$a));
			if($dayone==0) $dayone=7;
			if (9<=$m && $m<=12) {
			  echo "<center>
			        <form action=\"index.php?id=1\" method=\"post\" id=\"monFormulaire\">
			          <select name=\"m\" size=\"1\" onchange=\"document.getElementById('monFormulaire').submit();\">
			            <option value=\"9\" ".(($m==9)?'selected':'').">Septembre ".$a."</option>
			            <option value=\"10\" ".(($m==10)?'selected':'').">Octobre ".$a."</option>
			            <option value=\"11\" ".(($m==11)?'selected':'').">Novembre ".$a."</option>
			            <option value=\"12\" ".(($m==12)?'selected':'').">Décembre ".$a."</option>
			          </select>
			        </form><br/><br/>";
			} else {
			  echo "<center>
			        <form action=\"index.php?id=1\" method=\"post\" id=\"monFormulaire\">
			          <select name=\"m\" size=\"1\" onchange=\"document.getElementById('monFormulaire').submit();\">
			            <option value=\"1\" ".(($m==1)?'selected':'').">Janvier ".$a."</option>
			            <option value=\"2\" ".(($m==2)?'selected':'').">Février ".$a."</option>
			            <option value=\"3\" ".(($m==3)?'selected':'').">Mars ".$a."</option>
			            <option value=\"4\" ".(($m==4)?'selected':'').">Avril ".$a."</option>
			            <option value=\"5\" ".(($m==5)?'selected':'').">Mai ".$a."</option>
			            <option value=\"6\" ".(($m==6)?'selected':'').">Juin ".$a."</option>
			          </select>
			        </form><br/><br/>";
			}
			// calcul du nombre de semaines soit nb_jour ds le mois diviser par 7 et on arrondit au superieur
			$jours_in_month=cal_days_in_month(CAL_GREGORIAN,$m,$a);
			$jours_a_afficher=ceil(($jours_in_month+$dayone-1)/7)*7;
			echo '<table cellspacing=0><tr>';// affichage du tableau
			echo '<td>Lundi</td><td>Mardi</td><td>Mercredi</td><td>Jeudi</td><td>Vendredi</td><td>Samedi</td><td>Dimanche</td>';
			for ($i=1;$i<=$jours_a_afficher;$i++) {
			  if ($i%7 == 1) {
			    echo'</tr><tr>';
			  }
			  if ($i<($jours_in_month+$dayone) && $i>=$dayone) {
			    if($m == 1 || $m == 2 || $m == 3 || $m == 4 || $m == 5 || $m == 6 || $m == 7 || $m == 8 || $m == 9) {
			      $mois = "0".$m;
			    } else {
			      $mois = $m;
			    }
			    if(($i-$dayone+1) == 1 || ($i-$dayone+1) == 2 || ($i-$dayone+1) == 3 || ($i-$dayone+1) == 4 || ($i-$dayone+1) == 5 ||
			    ($i-$dayone+1) == 6 || ($i-$dayone+1) == 7 || ($i-$dayone+1) == 8 || ($i-$dayone+1) == 9) {
			      $jour = "0".($i-$dayone+1);
			    } else {
			      $jour = $i-$dayone+1;
			    }
			    $date_case = $a."-".$mois."-".$jour;
			    $existe = "false";
			    foreach ($planning as $value) {
			      if ($value['date'] == $date_case) {
			        $existe = "true";
			      }
			    }
			    if ($existe == "true") {
			      echo "<td><form action=\"index.php?id=1\" method=\"post\" style=\"margin:0\">
			        <input type=\"hidden\" name=\"date_faite\" value=\"".$date_case."\"/>
			        <input type=\"submit\" value=\"$jour\" name=\"valider\"/>
			      </form></td>";
			    } else {
			      echo "<td>".$jour."</td>";
			    }
			  } else {
			    echo "<td bgcolor=silver>&nbsp;</td>";//case des jours hors du mois
			  }
			}
			echo "</tr></table></br>";

			if(!isset($_POST['date_faite'])) {
			  echo"</center></body></html>";
			}
			$this->ajouterDate($nb_grp);
			echo"</br>";
		}

		public function afficherPlanningInfos($planning, $tab_date, $tab_grp, $tab_enc, $enc, $tab_grp_nb) {
			$nb_grp = sizeof($tab_grp_nb);
			$this->afficherPlanning($planning, $nb_grp);
			echo "<div><center>";
			foreach($tab_date as $value_date){
				$date_case = $value_date['date'];
			    $date_affichage = "<div>Date de l'activité: ".$value_date['date']."
			          </br>Commentaire sur l'activité: ".$value_date['commentaire']."
			          </br>Groupes de l'activité: ";
			    foreach ($tab_grp as $value_grp) {
			      if ($value_grp['idA'] == $value_date['id']) {
			        $date_affichage .= $value_grp['idG']." - ";
			      }
			    }
			    $date_affichage = rtrim($date_affichage, " - ");
			    $date_affichage .=  "</br>Encadrants de l'activité: ";
			    foreach ($tab_enc as $value_enc) {
			      if ($value_enc['idA'] == $value_date['id']) {
							foreach ($enc as $value_nomEnc) {
								if ($value_nomEnc['id'] == $value_enc['idE']) {
									if ($value_enc['valide'] == 0) {
				        		$date_affichage .=  $value_nomEnc['nom']." ".$value_nomEnc['prenom']."
										<form action=\"index.php?id=1\" method=\"post\" id=\"monFormulaire\">
							        <input type=\"hidden\" name=\"date_faite\" value=\"".$date_case."\"/>
											<select name=\"couleur_grp\" size=\"1\" onchange=\"document.getElementById('monFormulaire').submit();\">
												<option value=\"\" selected>Choisissez un groupe</option>";
										foreach ($tab_grp_nb as $value_grp_nb) {
											$date_affichage .= "<option name=\"couleur[]\" value=\"".$value_grp_nb['couleur']."\" style=\"background-color:#".$value_grp_nb['couleur'].";\">Groupe ".$value_grp_nb['id']."</option>";
										}
										$date_affichage .= "</select></form>";
									} else {
				        		$date_affichage .=  $value_nomEnc['nom']." ".$value_nomEnc['prenom']." - ";
									}

								}
							}
			      }
			    }
			    $date_affichage = rtrim($date_affichage, " - ");
			    $date_affichage .=  "</div>";
			    echo $date_affichage."</br></br>";
			}
			echo "</center></div>";
		}

		public function ajouterDate($nb_grp) {
			echo "<script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js\" type=\"text/javascript\"></script>
						<script src=\"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js\" type=\"text/javascript\"></script>
						<script>
							$(function() {
								$(\"#datepicker\").datepicker({
									dateFormat: \"yy-mm-dd\",
									maxDate: \"+3Y\",
									minDate: \"-1Y\",
									showButtonPanel: true,
									changeMonth: true,
									changeYear: true
								});
							});
						</script><center>
						<form action=\"index.php?id=1&date=".rand(0,999)."\" method=\"post\">
						<p>Date <input type=\"text\" name=\"date\" id=\"datepicker\"/></p><p>";
						for ($g=1; $g <= $nb_grp; $g++) {
							echo "Groupe ".$g."<input type=\"checkbox\" name=\"grp[]\" value=\"".$g."\">";
						}
						echo "</p><p><textarea placeholder=\"Entrez un commentaire sur l'activitée\" name=\"com\"></textarea></p>
						<input type=\"submit\" name=\"ajouterDate\" value=\"Ajouter une date\" />
						</form></center>";
		}

	//vue configuration
	public function AffichegestionConfigAdmin($info){

						echo "<form action=\"index.php?id=4\" method=\"post\" onsubmit=\"verifPasswd(this)\">";
							for ($i=1; $i <= sizeof($info); $i++) {
						echo	"<center></br><table><table>
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
									</table>";


									echo" <center></br><table>
									<tr>
										<td> Nouveau Mot de Passe</td>
										<td> <input type=\"password\" name=\"password1\" /></td>
									</tr>
									<tr>
										<td> Nouveau Mot de Passe</td>
										<td> <input type=\"password\" name=\"password2\" /></td>
									</tr>
									<tr>
										<td> <input type=\"submit\" name=\"enregistrement\" value=\"Enregistrer\"/></td>
									</tr>
									</table></table>";

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
						echo "</form></body>";

						}








} ?>
