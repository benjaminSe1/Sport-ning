<?php
require_once 'ctrlUtilisateur.php';
require_once 'ctrlAuthentification.php';
require_once 'ctrlMdpOublie.php';
require_once 'ctrlAdministrateur.php';
require_once 'Modele/dao/Dao.php';

class Routeur {
  private $ctrlUtilisateur;
  private $ctrlAdministrateur;
  private $ctrlAuthentification;
  private $dao;

  public function __construct() {
  		$this->ctrlUtilisateur = new ctrlUtilisateur();
  		$this->ctrlAdministrateur = new ctrlAdministrateur();
  		$this->ctrlAuthentification = new ctrlAuthentification();
      $this->ctrlMdpOublie = new ctrlMdpOublie();
      $this->dao = new Dao();
  }

  public function routerRequete() {
    //$ctrlMdpOublie= new ctrlMdpOublie();
    $vue = new utilitairePageHtml();

    // // Déjà connecté i.e session=ok
    if(isset($_SESSION['ok'])) {
      //Séléction d'un menu dans la barre de menu
      if(isset($_GET['id'])) {
        //Accès menu 1
        if ($_GET['id']==1)
        {
          if ($_SESSION['admin']==false){
            echo $vue->genereEnteteHtml();
            echo $vue->itemsBandeauApresConnexion();
            $this->ctrlUtilisateur->afficherPlanning();
            echo $vue->generePied();
          } else {
            echo $vue->genereEnteteHtml();
            echo $vue->itemsBandeauApresConnexionAdmin();
            if (isset($_POST['ajouterDate'])) {
              $this->ctrlAdministrateur->insererActivite();
              unset($_POST['ajouterDate']);
            } elseif(isset($_POST['couleur'])) {
              $this->ctrlAdministrateur->validerDispo($_POST['date_faite']);
            } elseif(isset($_POST['date_faite'])) {
              $this->ctrlAdministrateur->afficherPlanningInfos();
            } else {
              $this->ctrlAdministrateur->afficherPlanning();
            }
            echo $vue->generePied();
          }
        }
        if ($_GET['id']==2) {
          if ($_SESSION['admin']==false) {
            echo $vue->genereEnteteHtml();
            echo $vue->itemsBandeauApresConnexion();
            if (isset($_POST['date'])) {
              $this->ctrlUtilisateur->updtDispo();
            }
            $this->ctrlUtilisateur->afficherPlanningDispo();
            echo $vue->generePied();
          } else {
            echo $vue->genereEnteteHtml();
            echo $vue->itemsBandeauApresConnexionAdmin();
            if (isset($_POST['Supprimer'])) {
              $this->ctrlAdministrateur->supprimerGroupe($_POST['Supprimer']);
              unset($_POST['Supprimer']);
            }
            if (isset($_POST['Supprimer'])) {
              echo $_POST['id'];
              $this->ctrlAdministrateur->supprimerGroupe($_POST['id']);
              unset($_POST['Supprimer']);
            }
            $this->ctrlAdministrateur->afficherGroupes();
            echo $vue->generePied();
          }
        }
        if ($_GET['id']==3) {
          if ($_SESSION['admin']==false) {
            echo $vue->genereEnteteHtml();
            echo $vue->itemsBandeauApresConnexion();
            if(isset($_POST['password1']) && isset($_POST['password2']) && $_POST['password1'] == $_POST['password2'] ){
              $this->ctrlUtilisateur->updMDPEncadrant();
            }
            $this->ctrlUtilisateur->updtinfoEncadrant();
            $this->ctrlUtilisateur->afficherUnEncadrant();
            echo $vue->generePied();
          } else {
            echo $vue->genereEnteteHtml();
            echo $vue->itemsBandeauApresConnexionAdmin();
            if (isset($_POST['ModifierE'])) {
              $this->ctrlAdministrateur->modifierEncadrant($_POST['login']);
              unset($_POST['ModifierE']);
            }
            if (isset($_POST['AjoutEncadrant'])) {
              $_SESSION['login'] = $_POST['login'];
              $_SESSION['mail'] = $_POST['mail'];
              $this->ctrlAdministrateur->ajouterEncadrant();
              /*$this->ctrlMdpOublie->genere_token($_POST['login']);
              $token = $this->ctrlMdpOublie->get_token($_POST['login']);
              $this->ctrlMdpOublie->envoie_mail_reset($_POST['mail'], $token, $_POST['login']);
              $_SESSION['t'] = $token;*/
              unset($_POST['AjoutEncadrant']);
            }
            $this->ctrlAdministrateur->afficherEncadrants();
            echo $vue->generePied();
          }
        }
        if ($_GET['id']==4 && $_SESSION['admin']==true ) {
          echo $vue->genereEnteteHtml();
          echo $vue->itemsBandeauApresConnexionAdmin();
          if(isset($_POST['password1']) && isset($_POST['password2']) && $_POST['password1'] == $_POST['password2'] ){
            $this->ctrlAdministrateur->updMDPAdmin();
          }
          $this->ctrlAdministrateur->updtinfoAdmin();
          $this->ctrlAdministrateur->afficherUnAdmin();

          echo $vue->generePied();
        }

        if($_GET['id']==5 && $_SESSION['admin']==true && $this->dao->getAdmin($_SESSION['login']) == 1){
          $_SESSION['admin']= false;
          echo $vue->genereEnteteHtml();
          echo $vue->itemsBandeauApresConnexion();
          echo "<br/><br/><br/>
                <h2>Page d'accueil principale</h2>";
          echo $vue->generePied();
        }elseif($_GET['id']==4 && $_SESSION['admin']== false && $this->dao->getAdmin($_SESSION['login']) == 1){
            $_SESSION['admin']= true;
            echo $vue->genereEnteteHtml();
            echo $vue->itemsBandeauApresConnexionAdmin();
            echo "<br/><br/><br/>
                  <h2>Page d'accueil principale</h2>";
            echo $vue->generePied();
        }elseif($_GET['id']==4 && $_SESSION['admin']== false && $this->dao->getAdmin($_SESSION['login']) == 0){
          $_SESSION['admin']= false;
          echo $vue->genereEnteteHtml();
          echo $vue->itemsBandeauApresConnexion();
          echo "<center><img src='Vue/img/404.jpg'></center>";
          echo $vue->generePied();
        }

        if ($_GET['id']==0)
        {
          $_SESSION = array();
          session_destroy();
          echo $vue->genereEnteteHtml();
          $this->ctrlAuthentification->authentification();
          echo "<p style='color:red; text-align: center'>Vous avez été déconnecté(e) </p>";
          echo $vue->generePied();
        }

        if ($_GET['id']!=0 && $_GET['id']!=1 && $_GET['id']!=2 && $_GET['id']!=3 && $_GET['id']!=4 && $this->dao->getAdmin($_SESSION['login']) == 0)
        {
          echo $vue->genereEnteteHtml();
          echo $vue->itemsBandeauApresConnexion();
          echo "<center><img src='Vue/img/404.jpg'></center>";
          echo $vue->generePied();
        }
        else if ($_GET['id']!=0 && $_GET['id']!=1 && $_GET['id']!=2 && $_GET['id']!=3 && $_GET['id']!=4 && $_GET['id']!=5 && $this->dao->getAdmin($_SESSION['login']) == 1)
        {
          echo $vue->genereEnteteHtml();
          echo $vue->itemsBandeauApresConnexionAdmin();
          echo "<center><img src='Vue/img/404.jpg'></center>";
          echo $vue->generePied();
        }
      } else  if ($_SESSION['admin']==true ) {
        echo $vue->genereEnteteHtml();
        echo $vue->itemsBandeauApresConnexionAdmin();
        echo "<br/><br/><br/>
              <h2>Page d'accueil principale</h2>";
        echo $vue->generePied();
      }
      else if($_SESSION['admin']== false ){
        echo $vue->genereEnteteHtml();
        echo $vue->itemsBandeauApresConnexion();
        echo "<br/><br/><br/>
              <h2>Page d'accueil principale</h2>";
        echo $vue->generePied();
      }
    }
    else
    {
      echo $vue->genereEnteteHtml();
      if(isset($_POST['mdpOublie']) || isset($_GET['t']) || isset($_POST['submitLogMail']) || isset($_POST['submitMdpModif']))
      {
          if(isset($_POST['mdpOublie']) && !isset($_GET['t']) && !isset($_POST['submitLogMail']) && !isset($_POST['submitMdpModif']))
          {
            $this->ctrlMdpOublie->genereVueReinitMotDePasse();
          }
          else if(isset($_POST['mdpOublie']) && isset($_GET['t']) && !isset($_POST['submitLogMail'])&& !isset($_POST['submitMdpModif']))
          {
            $_SESSION['t'] = $_GET['t'];
            $this->ctrlMdpOublie->genereVueModifMotDePasse("");
          }
          else if(isset($_POST['submitLogMail']) && !isset($_POST['mdpOublie']) && !isset($_GET['t'])&& !isset($_POST['submitMdpModif']))
          {
           if($this->ctrlMdpOublie->verif_login_mail(htmlspecialchars($_POST['loginRecup']),htmlspecialchars($_POST['mailRecup'])))
            {
              $_SESSION['login'] = $_POST['loginRecup'];
              $_SESSION['mail'] = $_POST['mailRecup'];
              $this->ctrlMdpOublie->genere_token($_POST['loginRecup']);
              $token = $this->ctrlMdpOublie->get_token($_POST['loginRecup']);
              $this->ctrlMdpOublie->envoie_mail_reset($_POST['mailRecup'], $token, $_POST['loginRecup']);
              $_SESSION['t'] = $token;
              $this->ctrlAuthentification->authentification();
              echo '<script type="text/javascript">window.alert("un mail vous a été envoyé")</script>';
            }
            else
            {
              $this->ctrlMdpOublie->genereVueReinitMotDePasse();
              echo '<script type="text/javascript">window.alert("rentrer un mail/login valide")</script>';
            }
          }
          else if(!isset($_POST['submitLogMail']) && !isset($_POST['mdpOublie']) && isset($_GET['t']) && !isset($_POST['submitMdpModif']))
          {
            $_SESSION['t'] = $_GET['t'];
            $this->ctrlMdpOublie->genereVueModifMotDePasse();
          }
          else if(!isset($_POST['submitLogMail']) && !isset($_POST['mdpOublie']) && !isset($_GET['t']) && isset($_POST['submitMdpModif']))
          {
              if($_POST['mdpReinit1'] != $_POST['mdpReinit2'] )
              {
                  $this->ctrlMdpOublie->genereVueModifMotDePasse();
                  echo '<script type="text/javascript">alert("Les deux mots de passes ne correspondent pas")</script>';
              }
              else if(strlen($_POST['mdpReinit1']) < 3)
              {
                  $this->ctrlMdpOublie->genereVueModifMotDePasse();
                  echo '<script type="text/javascript">alert("Le mot de passe doit contenir au moins 7 caractères")</script>';
              }
              else if($_SESSION['login'] != $_POST['loginModif'] || $_SESSION['mail'] != $_POST['mailModif'])
              {
                $this->ctrlMdpOublie->genereVueModifMotDePasse();
                echo '<script type="text/javascript">alert("Login et/ou mail ne correspondent pas")</script>';
              }
              else if($_SESSION['login'] == $_POST['loginModif'] && $_SESSION['mail'] == $_POST['mailModif'])
              {
                if($_SESSION['t'] == $this->ctrlMdpOublie->get_token($_POST['loginModif']))
                {
                  $this->ctrlMdpOublie->reinit_mot_de_passe($_SESSION['login'],$_SESSION['mail'],$_POST['mdpReinit1']);
                  $this->ctrlMdpOublie->sup_token($_SESSION['login']);
                  unset($_SESSION['login']);
                  unset($_SESSION['mail']);
                  unset($_SESSION['t']);
                  $this->ctrlAuthentification->authentification();
                  echo '<script type="text/javascript">alert("Votre mot de passe a été modifié avec succès")</script>';
                }
                else{
                  unset($_SESSION['login']);
                  unset($_SESSION['mail']);
                  unset($_SESSION['t']);
                  $this->ctrlMdpOublie->sup_token($_SESSION['login']);
                }
              }
              else{
                echo 'Vous n\avez rien à faire ici';
              }
          }
      }
      else
      {
        $this->ctrlAuthentification->authentification();
      }
      echo $vue->generePied();
    }
  }
} ?>
