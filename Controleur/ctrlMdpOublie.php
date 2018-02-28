<?php 
require_once __DIR__."/../Vue/vueMotDePasseOublie.php";

class ctrlMdpOublie
{

	private $vue ;


	public function __construct()
	{
		$this->vue=new vueMotDePasseOublie(); 
		$this->dao = new Dao();
	} 

	public function verif_login_mail($log,$mail)
	{
		return $this->dao->verif_login_mail($log,$mail) ;
	}

	public function reinit_mot_de_passe($login,$mail,$mdp)
	{
		$this->dao->reinit_mot_de_passe($login,$mail,$mdp);
	}

	/*fonction qui permet de générer un mail automatiquement et de l'envoyer
$mail adresse du destinataire
$token et $login paramètres qui composeront l'url qui sera envoyé dans le mail pour reinit le mot de passe du compte
*/
	public function envoie_mail_reset($mail, $token, $login){
		if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail)) // On filtre les serveurs qui rencontrent des bogues.
		{
			$passage_ligne = "\r\n";
		}
		else
		{
			$passage_ligne = "\n";
		}


		//=====Déclaration des messages au format texte et au format HTML==============================
		$message_html = '
		<html>
		<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		</head>
		<body>
		<b>Bonjour</b>, 
		<br>
		Cet e-mail a été envoyé automatiquement. Si vous n\'avez pas demandé la réinitialisation de votre mot de passe, veuillez ignorer cet e-mail.
		<br>
		<br>
		<br>
		Cet email a été envoyé suite à une demande de réinitialisation de mot de passe sur le site Sport\'ning. si vous n\'avez pas éffectué cette demande, veuillez ignorer ce mail
		sinon, cliquer sur le lien qui suit pour le réinitialiser : 
		<br>
		<a href=http://infoweb/~planning-club/index.php?t='.$token.' > http://infoweb/~planning-club/index.php?t='.$token.'</a>
		<br>
		<br>
		<br>
		</body>
		</html>';
		//==========
		 
		//=====Création de la boundary==============================
		$boundary = "-----=".md5(rand());
		//==========
		 
		//=====Définition du sujet==============================
		$sujet = "Récupération de mot de passe Sport'ning club";
		//=========
		 
		//=====Création du header de l'e-mail==============================
		$header = "From: \"Sport\'ning\"<www-data@infoweb.iut-nantes.univ-nantes.prive>".$passage_ligne;
		$header.= "Reply-to: \"Sport\'ning\" <notReply@notReply.com>".$passage_ligne;
		$header.= "MIME-Version: 1.0".$passage_ligne;
		$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
		//==========
		 
		//=====Création du message==============================
		$message = $passage_ligne."--".$boundary.$passage_ligne;
		//==========
		$message.= $passage_ligne."--".$boundary.$passage_ligne;
		//=====Ajout du message au format HTML==============================
		$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
		$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
		$message.= $passage_ligne.$message_html.$passage_ligne;
		//==========
		$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
		$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
		//==========
		 
		//=====Envoi de l'e-mail==============================
		mail($mail,$sujet,$message,$header);
		//==========
	}

	/*
fonction qui permet de générer un token dans la base de donnée pour un compte donné ($login)
*/
	public function genere_token($login)
	{
		return $this->dao->generer_token($login);
	}

	/*
fonction qui permet de récupérer le token de la base de donnée pour un compte donné ($login)
*/
	public function get_token($login)
	{
		return $this->dao->get_token($login);
	}

	/*
fonction qui permet de générer la vue de demande de modofication de mot de passe
*/
	public function genereVueModifMotDePasse(){
		$this->vue->genererMdpOublie();
		unset($_SESSION['mdp']);
	}

	public function genereVueReinitMotDePasse(){
		$this->vue->genereVueReinitMotDePasse();
	}
		/*
fonction qui permet de récuperer dans la base de donnée un mail associé a un login
*/
	public function get_mail($login){
		$this->dao->get_mail($login);
	}

	public function sup_token($log){
		$this->dao->sup_token($log);
	}

}

 ?>