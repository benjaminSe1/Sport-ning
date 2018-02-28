<?php
require_once __DIR__."/../Vue/vueAuthentification.php";
require_once __DIR__."/../Vue/util/utilitairePageHtml.php";
require_once __DIR__."/../Modele/dao/Dao.php";

class ctrlAuthentification
{

	private $vueAuthentification ;


	public function __construct()
	{
		$this->vue=new vueAuthentification();
	}



	public function authentification()
	{

	if(isset($_POST['login']) && isset($_POST['password']))
	{
		if(!empty($_POST['login']) && !empty($_POST['password']))
		{
			$dao = new Dao(); // Tester les identifiants
			$dao2 = new Dao();

			if($dao->verifieMotDePasse($_POST['login'], $_POST['password']) == true )
			{
				$_SESSION['login'] = $_POST['login'];
				//Vue administrateur
				if ($dao2->verifieAdmin($_POST['login']))
				{
					$_SESSION['admin']=true ;
					$vue = new UtilitairePageHtml();
					echo $vue->genereEnteteHtml();
					echo $vue->itemsBandeauApresConnexionAdmin();
					echo $vue->generePied();
					$_SESSION['ok'] = true ;
					echo "<br/>";
		            echo "<br/>";
		            echo "<br/>";
					echo "<h2>Page d'accueil principale admin</h2>";
				}
				else // Vue encadrant
				{
					$_SESSION['admin']=false ;
					$vue = new UtilitairePageHtml();
					echo $vue->genereEnteteHtml();
					echo $vue->itemsBandeauApresConnexion();
					echo $vue->generePied();
					$_SESSION['ok'] = true ;
					echo "<br/>";
		            echo "<br/>";
		            echo "<br/>";
					echo "<h2>Page d'accueil principale encadrant</h2>";
				}
			}
			else // identifiants incorrect
			{
		 		$this->vue->genererVueAuthentification();
		 		echo "<p style='color:red; text-align: center'>Login ou password incorrect(s)</p>";
			}
		}
		else // identifiants incorrect
		{
	 		$this->vue->genererVueAuthentification();
	 		echo "<p style='color:red; text-align: center'>Veuillez saisir vos identifiants</p>";
		}

	}
	else //Page de connexion
	{

		$this->vue->genererVueAuthentification();

	}

	}


	public function RecupPassword()
	{
		$this->vue->genererMdpOublie();
		unset($_SESSION['mdp']);
	}

}

 ?>
