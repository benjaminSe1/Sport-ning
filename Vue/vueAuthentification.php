<?php


class vueAuthentification
{

	public function genererVueAuthentification()
	{
		?>


	<!doctype html>
		<head>
		<link rel="stylesheet" type="text/css" href="Vue/css/authentification.css">
		</head>
		<body background="Vue/img/login.jpg">

			<!-- Message d'accueil -->
			<h1>Bienvenue sur SPORT'NING, le site de gestion de planning pour les clubs sportifs</h1>
			<br/>
			<br/>


		<h2 align="center"> Authentifiez vous !!! </h2>

		<!-- Cadre de connexion-->
		<form action="index.php" method="post">
			<table>
				<!-- Login -->
				<tr>
				<td> <p> Entrez votre login : </p>	 </td>
				<td><input type="text"  name ="login" /> </td>
				</tr>

				<!-- Mot de passe -->
				<tr>
				<td> <p> Entre votre mot de passe: </p>		</td>
				<td> <input type="password" name ="password" />	</td>
				</tr>

				<!-- Validation -->
				<tr>
				<td> <input type="submit" align="center" /></td>
				<td> <input name="mdpOublie" type="submit" align="center" value="Mot de passe oublié ?"/></td>
				</tr>
			</table>
		</form>
		<!-- Fin cadre de connexion -->

		</body>
	</html>

	<?php

	}


		public function genererMdpOublie()
	{
		?>


	<!doctype html>
		<head>
			<link rel="stylesheet" type="text/css" href="Vue/css/authentification.css">
			<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		</head>


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
				<td><input type="text"  name ="login" /> </td>
				</tr>

				<!-- Mot de passe -->
				<tr>
				<td> <p> Entrez votre e-mail </p>		</td>
				<td> <input placeholder="Mail@domain.com" type="email" name ="password" />	</td>
				</tr>

				<!-- Validation -->
				<tr>
				<td><input name="retourMenuMdp" type="submit" align="center" value="Menu principal"/></td>
				<td> <input name="validerMdpOublie" type="submit" align="center" value="Récupérer mon mot de passe"/></td>
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
