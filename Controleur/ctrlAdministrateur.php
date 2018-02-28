<?php
require_once __DIR__."/../Modele/dao/Dao.php";
require_once __DIR__."/../Vue/vueAdministrateur.php";
require_once __DIR__."/../Vue/vueGroupeEncadrant.php";

class ctrlAdministrateur {
  private $dao;
  private $vueAdmin;
  private $vueGE;

  function __construct() {
    $this->dao = new Dao();
    $this->vueAdmin = new vueAdministrateur();
    $this->vueGE = new vueGroupeEncadrant();
  }

  function afficherPlanning() {
    $tab = $this->dao->recupDatesComplet();
    $tab_grp = $this->dao->recupGroupes();
    $planning = array();
    for ($i = 1; $i <= sizeof($tab); $i++) {
        $planning[$i] = array("id"=>$tab[$i-1]['id'], "date" => $tab[$i-1]['date'], "commentaire" => $tab[$i-1]['commentaire']);
    }
    $nb_grp = sizeof($tab_grp);
    $this->vueAdmin->afficherPlanning($planning, $nb_grp);
  }

  public function afficherPlanningInfos() {
    $tab = $this->dao->recupDatesComplet();
    $planning = array();
    for ($i = 1; $i <= sizeof($tab); $i++) {
        $planning[$i] = array("id"=>$tab[$i-1]['id'], "date" => $tab[$i-1]['date'], "commentaire" => $tab[$i-1]['commentaire']);
    }
    echo $_POST['date_faite'];
    $tab_date = $this->dao->recupInfosDate($_POST['date_faite']);
    $tab_grp = $this->dao->recupGroupesComplet();
    $tab_enc = $this->dao->recupEncadrantsComplet();
    $enc = $this->dao->recupNomEncadrants();
    $tab_grp_nb = $this->dao->recupGroupes();
    $this->vueAdmin->afficherPlanningInfos($planning, $tab_date, $tab_grp, $tab_enc, $enc, $tab_grp_nb);
  }

  public function validerDispo($date) {
    echo $date;
    $_POST['date_faite'] = $date;
    $this->afficherPlanningInfos();
  }

  public function insererActivite() {
    $this->dao->insererActivite();
  }

  /*Gestion Encadrant*/
  public function afficherEncadrants(){
    $tab = $this->dao->recupEncadrants();
    $enca = array();
    for($i=1 ; $i<= sizeof($tab); $i++){
      $enca[$i] =  array("nom"=>$tab[$i-1]['nom'], "prenom"=>$tab[$i-1]['prenom'], "telephone"=>$tab[$i-1]['telephone'], "adresse"=>$tab[$i-1]['adresse'], "login"=>$tab[$i-1]['login'],
      "mail"=>$tab[$i-1]['mail'],"admin"=>$tab[$i-1]['admin'],"actif"=>$tab[$i-1]['actif']);
    }
    $this->vueGE->afficherEncadrants($enca);
  }

  public function ajouterEncadrant() {
		$this->dao->ajoutEncadrant();

	}

  public function modifierEncadrant($login) {
    $this->dao->modifieEncadrant($login);

  }

/*GestionGroupe*/
public function afficherGroupes(){
  $tab = $this->dao->recupGroupes();
  $grp = array();
  for($i=1 ; $i<= sizeof($tab); $i++){
    $grp[$i] =  array("id"=>$tab[$i-1]['id']);
  }
  $this->vueGE->afficherGroupes($grp);
}
  public function ajouterGroupe() {
		$this->dao->ajoutGroupe();

	}

  public function supprimerGroupe($id) {
    $this->dao->supprimeGroupe($id);

  }
  /*Gestion Encadrant*/
  public function updtinfoAdmin(){
        $this->dao->ActualiserInfoEncadrant();
  }
  public function updMDPAdmin(){
        $this->dao->ActualiserMDP();
  }

  public function afficherUnAdmin(){
    $tab = $this->dao->recupUnEncadrant();
     $enca = array();
     for($i=1 ; $i<= sizeof($tab); $i++){
       $enca[$i] =  array("nom"=>$tab[$i-1]['nom'], "prenom"=>$tab[$i-1]['prenom'], "telephone"=>$tab[$i-1]['telephone'], "adresse"=>$tab[$i-1]['adresse'],
       "mail"=>$tab[$i-1]['mail']);
     }
     $this->vueAdmin->AffichegestionConfigAdmin($enca);
  }

}

?>
