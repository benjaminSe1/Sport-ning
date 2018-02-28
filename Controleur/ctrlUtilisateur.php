<?php
require_once __DIR__."/../Modele/dao/Dao.php";
require_once __DIR__."/../Vue/vueUtilisateur.php";

class ctrlUtilisateur {
  private $dao;
  private $vueUser;

  function __construct() {
    $this->dao = new Dao();
    $this->vueUser = new vueUtilisateur();
  }

  function afficherPlanning() {
  	$tab = $this->dao->recupDatesComplet();
    $tab_grp = $this->dao->recupGroupesComplet();
    $tab_enc = $this->dao->recupEncadrantsComplet();
  	$planning = array();
  	for($i = 1; $i <= sizeof($tab); $i++){
        $planning[$i] = array("id"=>$tab[$i-1]['id'], "date" => $tab[$i-1]['date'], "commentaire" => $tab[$i-1]['commentaire']);
    }
    foreach ($tab_grp as $value) {
      $planning[$value['idA']]['grp'.$value['idG']]=1;
    }
    foreach ($tab_enc as $value) {
      $planning[$value['idA']]['enc'.$value['idE']]=1;
    }
    $nb_enc = sizeof($this->dao->recupEncadrants());
    $nb_grp = sizeof($this->dao->recupGroupes());
    $encRel = $this->dao->recupPseudo();
    foreach ($encRel as $value) {
      $encRel[$value['id']] = $value['login'];
      $encRel[$value['login']] = $value['admin'];
    }
    $this->vueUser->afficherPlanning($planning, $nb_grp, $nb_enc, $encRel);
  }

  public function afficherPlanningDispo()
  {
  	$tab = $this->dao->recupDatesComplet();
    $tab_grp = $this->dao->recupGroupesComplet();
    $tab_enc = $this->dao->recupEncadrantsDispo();
  	$planning = array();
  	for($i = 1; $i <= sizeof($tab); $i++){
        $planning[$i] = array("id"=>$tab[$i-1]['id'], "date" => $tab[$i-1]['date'], "commentaire" => $tab[$i-1]['commentaire']);
    }
    foreach ($tab_grp as $value) {
      $planning[$value['idA']]['grp'.$value['idG']]=1;
    }
    foreach ($tab_enc as $value) {
      $planning[$value['idA']]['enc'.$value['idE']]=1;
    }
    $nb_grp = sizeof($this->dao->recupGroupes());
    $id_enc = $this->dao->recupId();

    $this->vueUser->afficherPlanningDispo($planning, $nb_grp, $id_enc);
  }

  public function updtDispo()
  {
    $this->dao->reinitDispo($_POST['date']);
    foreach ($_POST['dispo'] as $value) {
      if (!$this->dao->dispoDispo($_POST['date'], $value)) {
        $this->dao->insererDispo($_POST['date'], $value);
      }
    }
  }


  public function updtinfoEncadrant(){
        $this->dao->ActualiserInfoEncadrant();
  }
  public function updMDPEncadrant(){
        $this->dao->ActualiserMDP();
  }

  public function afficherUnEncadrant(){
    $tab = $this->dao->recupUnEncadrant();
     $enca = array();
     for($i=1 ; $i<= sizeof($tab); $i++){
       $enca[$i] =  array("nom"=>$tab[$i-1]['nom'], "prenom"=>$tab[$i-1]['prenom'], "telephone"=>$tab[$i-1]['telephone'], "adresse"=>$tab[$i-1]['adresse'],
       "mail"=>$tab[$i-1]['mail']);
     }
     $this->vueUser->AffichegestionConfig($enca);
  }




} ?>
