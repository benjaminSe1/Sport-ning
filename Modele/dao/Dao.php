<?php

require_once("ConnexionException.php");
require_once("AccesTableException.php");


class Dao {
  private $connexion;

 // permet d'ouvrir une connexion avec le sgbd
  public function connexion() {
    try {
	     //connexion
	      $this->connexion = new PDO('mysql:host=localhost;charset=UTF8;dbname=info2-2016-planenclub-db','info2-2016-pec','planenclub');	//on se connecte au sgbd
        $this->connexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);	//on active la gestion des erreurs et d'exceptions
    } catch (PDOException $e) {
	     throw new ConnexionException("Erreur de connexion");
    } //connexion reussie
  }

// cette fonction retourne la reponse a  la requete ci dessous
  public function getMotDePasse($login) {
    try {
      $this->connexion();
      $requete = $this->connexion->prepare('SELECT password FROM encadrants where login = :login');
      $requete->execute(array('login' => $login));
      $reponse = $requete->fetch();
      $this->deconnexion();
      return $reponse[0];
    } catch (PDOException $e) {
      throw new AccesTableException("problème de connexion à la base");
    }
  }

// cette fonction retourne la reponse a  la requete ci dessous
  public function getAdmin($login) {
    try {
      $this->connexion();
      $requete = $this->connexion->prepare('SELECT admin FROM encadrants where login = :login');
      $requete->execute(array('login' => $login));
      $reponse = $requete->fetch();
      $this->deconnexion();
      return $reponse[0];
    } catch (PDOException $e) {
      throw new AccesTableException("problème de connexion à la base");
    }
  }

// Test si l'user est un admin
  public function verifieAdmin($login) {
    $tmp = $this->getAdmin($login);
    return $tmp ;
  }



// cette fonction retourne la reponse a  la requete ci dessous
  public function verifieMotDePasse($login, $password) {
    $this->verifierValiditeToken(); // appel de la requete permettant de verifier date de validité token
    $mdpbd = $this->getMotDePasse($login);
    if (crypt($password, $mdpbd)== $mdpbd) {
      return true;
    } else {
      return false;
    }
  }

  //méthode pour récupérer toutes les dates du planning
  public function recupDatesComplet()
  {
        try
        {
          $this->connexion();
          $resultat = $this->connexion->query('SELECT * FROM activites order by id');
          $resultatTab = $resultat->fetchAll();
          $this->deconnexion();
          return $resultatTab;
        }
        catch (PDOException $e)
        {
          throw new AccesTableException("Problème de connexion à la base");
        }
  }

  //méthode pour récupérer toutes les infos des activités d'une date
  public function recupInfosDate($date)
  {
        try
        {
          $this->connexion();
          $resultat = $this->connexion->query('SELECT * FROM activites WHERE `date`=\''.$date.'\'');
          $resultatTab = $resultat->fetchAll();
          $this->deconnexion();
          return $resultatTab;
        }
        catch (PDOException $e)
        {
          throw new AccesTableException("Problème de connexion à la base");
        }
  }

  //méthode pour récupérer tous les groupes
  public function recupGroupesComplet()
  {
        try
        {
          $this->connexion();
          $resultat = $this->connexion->query('SELECT * FROM affectationGA aga order by aga.idA');
          $resultatTab = $resultat->fetchAll();
          $this->deconnexion();
          return $resultatTab;
        }
        catch (PDOException $e)
        {
          throw new AccesTableException("Problème de connexion à la base");
        }
  }

  //méthode pour récupérer tous les encadrants
  public function recupEncadrantsComplet()
  {
        try
        {
          $this->connexion();
          $resultat = $this->connexion->query('SELECT * FROM affectationEA aea order by aea.idA');
          $resultatTab = $resultat->fetchAll();
          $this->deconnexion();
          return $resultatTab;
        }
        catch (PDOException $e)
        {
          throw new AccesTableException("Problème de connexion à la base");
        }
  }

  //méthode pour récupérer tous les encadrants pour dispo
  public function recupEncadrantsDispo()
  {
        try
        {
          $this->connexion();
          $resultat = $this->connexion->query('SELECT aea.idE, aea.idA FROM affectationEA aea, encadrants e WHERE aea.idE=e.id and e.login=\''.$_SESSION['login'].'\' order by aea.idA');
          $resultatTab = $resultat->fetchAll();
          $this->deconnexion();
          return $resultatTab;
        }
        catch (PDOException $e)
        {
          throw new AccesTableException("Problème de connexion à la base");
        }
  }

  public function recupNomEncadrants() {
      try {
        $this->connexion();
        $requete = $this->connexion->query("SELECT id, prenom, nom FROM info_encadrants");
        $nom = $requete->fetchall();
        $this->deconnexion();
        return $nom;
      } catch (PDOException $e) {
        throw new AccesTableException("problème de connexion à la base");
      }
    }

  public function recupEncadrants() {
      try {
        $this->connexion();
        $requete = $this->connexion->query("SELECT ie.prenom, ie.nom, ie.telephone, ie.adresse, e.login, e.password, e.mail, e.admin, e.actif FROM info_encadrants ie, encadrants e WHERE e.id=ie.id ORDER BY nom");
        $ligne = $requete->fetchAll();
        $this->deconnexion();
        return $ligne;
      } catch (PDOException $e) {
        throw new AccesTableException("problème de connexion à la base");
      }
    }

     public function recupGroupes() {
       try {
         $this->connexion();
         $requete = $this->connexion->query("SELECT * FROM groupes ORDER BY id");
         $ligne = $requete->fetchAll();
         $this->deconnexion();
         return $ligne;
       } catch (PDOException $e) {
         throw new AccesTableException("problème de connexion à la base");
       }
     }

    public function recupId() {
      try {
        $this->connexion();
        $requete = $this->connexion->query("SELECT id FROM `encadrants` WHERE `login`='".$_SESSION['login']."' ");
        $ligne = $requete->fetch();
        $this->deconnexion();
        return $ligne;
      } catch (PDOException $e) {
        throw new AccesTableException("problème de connexion à la base");
      }
    }

    public function recupPseudo() {
      try {
        $this->connexion();
        $requete = $this->connexion->query("SELECT id, login, admin FROM `encadrants`");
        $ligne = $requete->fetchall();
        $this->deconnexion();
        return $ligne;
      } catch (PDOException $e) {
        throw new AccesTableException("problème de connexion à la base");
      }
    }

// Précondition : Groupe existe déjà (sinon erreur)
//

  // Cette methode permet d'insérer une nouvelle activité dans la base de données
  public function insererActivite()
  {
    try
    {
      $this->connexion();

      $requeteActivite = $this->connexion->prepare('insert INTO activites(date, commentaire) VALUES(?, ?)');
      $requeteActivite->bindParam(1,$_POST['date']);
      $requeteActivite->bindParam(2,$_POST['com']);
      $requeteActivite->execute();
      $idActivite = $this->getLastActivite();

      foreach ($_POST['grp'] as $value) {
        $this->connexion();
        $requeteAffectation = $this->connexion->prepare('insert INTO affectationGA VALUES(?, ?)');
        $requeteAffectation->bindParam(1,$value);
        $requeteAffectation->bindParam(2,$idActivite['id']);
        $requeteAffectation->execute();
      }

      $this->deconnexion();
    }
    catch (PDOException $e)
    {
      throw new AccesTableException("Problème de connexion à la base");
    }
  }

  // Méthode qui permet de recuperer la dernière activité insérée
  public function getLastActivite()
  {
    try
    {
      $this->connexion();

      $requete = $this->connexion->query('SELECT id from activites where id=(SELECT MAX(id) FROM activites)');
      $resultat = $requete->fetch();

      $this->deconnexion();
      return $resultat ;

    }
    catch (PDOException $e)
    {
      throw new AccesTableException("Problème de connexion à la base");
    }
  }

  // Méthode qui permet de ajouter une dispo
  public function reinitDispo($idEncadrant)
  {
    try
    {
      $this->connexion();

      $this->connexion->query('DELETE FROM `affectationEA` WHERE idE=\''.$idEncadrant.'\'');

      $this->deconnexion();
    }
    catch (PDOException $e)
    {
      throw new AccesTableException("Problème de connexion à la base");
    }
  }

  // Méthode qui permet de ajouter une dispo
  public function insererDispo($idEncadrant, $idActivite)
  {
    try
    {
      $this->connexion();

      $requeteinsertionD = $this->connexion->prepare('INSERT INTO affectationEA(`idE`, `idA`) VALUES(?, ?)');
      $requeteinsertionD->bindParam(1,$idEncadrant);
      $requeteinsertionD->bindParam(2,$idActivite);
      $requeteinsertionD->execute();

      $this->deconnexion();
    }
    catch (PDOException $e)
    {
      throw new AccesTableException("Problème de connexion à la base");
    }
  }

  // Méthode qui permet de ajouter une dispo
  public function dispoDispo($idEncadrant, $idActivite)
  {
    try
    {
      $this->connexion();
      $requeteSelectD = $this->connexion->prepare('SELECT * FROM affectationEA WHERE `idE`=".$idEncadrant." AND `idA`=".$idActivite.")');
      $this->deconnexion();
      return ($requeteSelectD->fetchColumn() == 0) ? false : true ;
    }
    catch (PDOException $e)
    {
      throw new AccesTableException("Problème de connexion à la base");
    }
  }

  public function validerDispo($idEncadrant, $idActivite)
  {
    try
    {
      $this->connexion();

      $requeteValideD = $this->connexion->query('UPDATE affectationEA set valide = 1 where idE = '.$idEncadrant.' and idA ='.$idActivite.';');

      $this->deconnexion();
    }
    catch (PDOException $e)
    {
      throw new AccesTableException("Problème de connexion à la base");
    }
  }

  /* GESTION DES ENCADRANTS */
  public function ajoutEncadrant(){
    try{
      $this-> connexion();
      $requeteAjoutE = $this->connexion->prepare('INSERT INTO `encadrants`(`login`, `admin`, `mail`) VALUES( ?, ?, ?)');
      $requeteAjoutE->bindParam(1,$_POST['login']);
      $requeteAjoutE->bindParam(2,$_POST['admin']);
      $requeteAjoutE->bindParam(3,$_POST['mail']);
      $requeteAjoutE->execute();
      $requete1 = $this->connexion->query("SELECT `id` FROM `encadrants` WHERE `login`='".$_POST['login']."' ");
      $id = $requete1->fetch();

      $requeteAjoutIE = $this->connexion->prepare('INSERT INTO `info_encadrants` VALUES(?, ?, ?, ?, ?)');
      $requeteAjoutIE->bindParam(1,$id[0]);
      $requeteAjoutIE->bindParam(2,$_POST['prenom']);
      $requeteAjoutIE->bindParam(3,$_POST['nom']);
      $requeteAjoutIE->bindParam(4,$_POST['telephone']);
      $requeteAjoutIE->bindParam(5,$_POST['adresse']);
      $requeteAjoutIE->execute();

      $this->deconnexion();
    } catch (PDOException $e) {
      throw new AccesTableException("problème de connexion à la base");
    }
  }



  public function modifieEncadrant($login){
    try{
      $this-> connexion();
      $requete1 = $this->connexion->query("SELECT `actif` FROM `encadrants` WHERE `login`='".$login."' ");
      $ligne = $requete1->fetch();
      if ($ligne['actif']==1){
        $this->connexion->query("UPDATE `encadrants` SET `actif`=0 WHERE `login`='".$login."' ");
      }else{
        $this->connexion->query("UPDATE `encadrants` SET `actif`=1 WHERE `login`='".$login."' ");
      }

      $this->deconnexion();
    } catch (PDOException $e) {
      throw new AccesTableException("problème de connexion à la base");
    }
  }

  /* GESTION DES GROUPES */
  public function ajoutGroupe(){
    try{
      $this-> connexion();
      $this->connexion->query("INSERT INTO `groupes`() VALUES ()");
      $this->deconnexion();
    } catch (PDOException $e) {
      throw new AccesTableException("problème de connexion à la base");
    }
  }

  public function supprimeGroupe($id){
    try{
      $this-> connexion();
      $this->connexion->query("DELETE FROM `groupes` WHERE `id`=".$id);




      $this->deconnexion();
    } catch (PDOException $e) {
      throw new AccesTableException("problème de connexion à la base");
    }
  }

  // Permet l'actualisation dans la base de donnée
  public function ActualiserInfoEncadrant(){
    try{
      $this->connexion();
      if(!empty($_POST['prenom']) && !empty($_POST['adresse']) && !empty($_POST['telephone']) && !empty($_POST['mail'])){
      $requete = $this->connexion->query('UPDATE info_encadrants ie, encadrants e SET ie.nom="'.$_POST["nom"].'", ie.prenom="'.$_POST["prenom"].'", ie.adresse="'.$_POST["adresse"].'", ie.telephone="'.$_POST["telephone"].'", e.mail ="'.$_POST["mail"].'"
      WHERE e.login=\''.$_SESSION['login'].'\' and e.id = ie.id;');
    }
      $this->deconnexion();
    }/* mot de passe de toto : $1$ioyh.rEY$nGrvVT3pO1JbFgkDiLDqy/ */
    catch (PDOException $e)
    {
      throw new AccesTableException("problème de connexion à la base");
    }
  }

  public function ActualiserMDP(){
    try{
      $this->connexion();
      if(empty($_POST['password1']) && empty($_POST['password2'] )){
      $requete = $this->connexion->query('UPDATE info_encadrants ie, encadrants e SET e.password = e.password WHERE e.login=\''.$_SESSION['login'].'\' and e.id = ie.id;');
    }
    elseif(!empty($_POST['password1']) == !empty($_POST['password2'])){
      $requete = $this->connexion->query('UPDATE info_encadrants ie, encadrants e SET  e.password ="'.crypt($_POST['password1']).'" WHERE e.login=\''.$_SESSION['login'].'\' and e.id = ie.id;');
      }
      $this->deconnexion();
    }
    catch (PDOException $e)
    {
      throw new AccesTableException("problème de connexion à la base");
    }
  }

  public function recupNom(){
    try {
      $this->connexion();
      $requete = $this->connexion->query('SELECT e.id, ie.prenom, ie.nom, ie.telephone, ie.adresse, e.login, e.password, e.mail FROM info_encadrants ie, encadrants e WHERE e.login=\''.$_SESSION['login'].'\' and e.id = ie.id ;');
      $recup = $requete->fetchAll();
      $this->deconnexion();
      return $recup;
    } catch (PDOException $e) {
      throw new AccesTableException("problème de connexion à la base");
    }
  }

  public function recupUnEncadrant() {
      try {
        $this->connexion();
        $requete = $this->connexion->query('SELECT e.id, ie.prenom, ie.nom, ie.telephone, ie.adresse, e.login, e.password, e.mail FROM info_encadrants ie, encadrants e WHERE e.login=\''.$_SESSION['login'].'\' and e.id = ie.id ;');
        $recup = $requete->fetchAll();
        $this->deconnexion();
        return $recup;
      } catch (PDOException $e) {
        throw new AccesTableException("problème de connexion à la base");
      }
    }

  public function verif_login_mail($login,$mail)
  {
    try
    {
      $this->connexion();
      $requete = $this->connexion->query("select * from encadrants where login='".$login."' and mail = '".$mail."';");
      $result = $requete->fetch();
      $this->deconnexion();

      return (($result['login'] == $login && isset($result['login'])) && ($result['mail'] == $mail && isset($result['mail']))) ;
    }
    catch (PDOException $e) {
      throw new AccesTableException("problème de connexion à la base");
    }
  }

public function generer_token($login){

$char = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$token = str_shuffle($char);
$token = substr($token, 1, 40);
try{
    $this->connexion();
    $sth = $this->connexion->query("UPDATE `encadrants` SET `token`= '".$token."', `dateToken`= NOW() WHERE login = '".$login."';");
    //$sth = $this->connexion->query("UPDATE `encadrants` SET `dateToken`= '".DateTime()."' WHERE login = '".$login."';");
    $this->deconnexion();
  }
  catch (PDOException $e) {
    throw new AccesTableException("problème de connexion à la base");
  }
  return $token;
}

public function get_token($login){
try{
    $this->connexion();
    $sth = $this->connexion->query("select token from encadrants where login='".$login."';");
    $result = $sth->fetch();
    return $result['token'];
  }
  catch (PDOException $e) {
    throw new AccesTableException("problème de connexion à la base");
  }
}

public function verifierValiditeToken() {
    try {
      $this->connexion();
      $sth = $this->connexion->prepare("UPDATE `encadrants` SET `token`= NULL, `dateToken`= NULL WHERE `dateToken` < DATE_SUB(NOW(), INTERVAL 10 HOUR);");
      $sth->execute();
      $this->deconnexion();
    } catch (PDOException $e) {
      throw new AccesTableException("problème de connexion à la base");
    }
  }

public function reinit_mot_de_passe($login,$mail,$mdp)
{
  try{
    $this->connexion();
    $sth = $this->connexion->query("UPDATE `encadrants` SET `password`='".crypt($mdp)."' WHERE `login` = '".$login."' and `mail` = '".$mail."';");
  }
   catch (PDOException $e) {
    throw new AccesTableException("problème de connexion à la base");
  }
}

public function sup_token($login){
try{
    $sth = $this->connexion->prepare("UPDATE `encadrants` SET `token`=".PDO::PARAM_NULL." WHERE login='".$login."';");
    $sth->execute();
  }
   catch (PDOException $e) {
    throw new AccesTableException("problème de connexion à la base");
  }
}





  //Methode permettant la deconnexion de la base de donnees
  public function deconnexion() {
      $this->connexion = null ;
  }
} ?>
