<?php




class vueMotDePasseOublie
{

	public function genereVueReinitMotDePasse()
	{
		?>


	<!doctype html>
		<head>
			<link rel="stylesheet" type="text/css" href="Vue/css/authentification.css">
			<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		</head>

		 <body background="Vue/img/login.jpg">
			<!-- Message d'accueil -->
			<h1>Bienvenue sur SPORT'NING, le site de gestion de planning pour les clubs sportifs</h1>
			<br/>
			<br/>

			<!-- Image d'accueil -->
			<div align="middle">
				<img src="Vue/img/lostpassword.jpg" style="width: 120px; height:120px" >
			</div>
<h2 align="center"> Vous avez oublié votre mot de passe ?  </h2>

<!-- Cadre de connexion-->
		<form action="index.php" method="post">
			<table>
				<!-- Login -->
				<tr>
				<td> <p> Entrez votre login : </p>	 </td>
				<td><input type="text"  name ="loginRecup" /> </td>
				</tr>

				<!-- Mot de passe -->
				<tr>
				<td> <p> Entrez votre e-mail </p>		</td>
				<td> <input placeholder="Mail@domain.com" type="email" name ="mailRecup" />	</td>
				</tr>

				<!-- Validation -->
				<tr>
				<td> <input name="submitLogMail" type="submit" align="center" value="Récupérer mon mot de passe"/></td>
				<td><input type="submit" align="center" value="Menu principal"/></td>
				</tr>
			</table>
		</form>
		<!-- Fin cadre de connexion -->


		</body>
	</html>

	<?php
}

public function genererMdpOublie(){
		?>
			<script type="text/javascript">
			</script>
		<!doctype html>
		<html>
		<head>
				<meta charset ="UTF-8">
				<link rel="stylesheet" type="text/css" href="Vue/css/authentification.css">
		</head>

		<body>
		<!-- Message d'accueil -->
		<h1>Bienvenue sur SPORT'NING, le site de gestion de planning pour les clubs sportifs</h1>
		<br/>
		<br/>

		<!-- Image d'accueil -->
		<div align="middle">
			<img src="Vue/img/lostpassword.jpg" style="width: 300px" >
		</div>
<h2 align="center"> Vous avez oublié votre mot de passe ?  </h2>

<!-- Cadre de connexion-->
	<form action="index.php" method="post">
		<table>
			<!-- Login -->
			<tr>
			<td> <p> Entrez votre login : </p>	 </td>
			<td><input type="text"  name ="loginModif" /> </td>
			</tr>

			<!-- Mot de passe -->
			<tr>
			<td> <p> Entrez votre e-mail : </p>		</td>
			<td> <input placeholder="Mail@domain.com" type="email" name ="mailModif" />	</td>
			</tr>

			<tr>
			<td> <p> Entrez votre nouveau mot de passe : </p>	 </td>
			<td><input type="password"  name ="mdpReinit1" /> </td>
			</tr>

			<tr>
			<td> <p> Veuillez entrer à nouveau votre novueau mot de passe: </p>	 </td>
			<td><input type="password"  name ="mdpReinit2" /> </td>
			</tr>

			<!-- Validation -->
			<tr>
		  <td></td>
			<td> <input name="submitMdpModif" type="submit"  align="center"  value="Envoyer"/></td>
			</tr>
		</table>
	</form>
	<!-- Fin cadre de connexion -->


	</body>

		</html>

		<?php
	}





}
?>
