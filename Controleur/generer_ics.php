<?php
require_once __DIR__."/../Modele/dao/Dao.php";

class genererICS {
  private $dao;

  function __construct() {
    $this->dao = new Dao();
  }

  function genererICS() {
    $result = $this->dao->recupDatesComplet();
    foreach ($result as $value) {
      $planning[$value['id']] = array('date' => $value['date'], 'commentaire' => $value['commentaire']);
    }
    $number = sizeof($planning);
    echo "Nombre de dates : ".$number;
    $monICS = "BEGIN:VCALENDAR
                VERSION:2.0
                PRODID:-//hacksw/handcal//NONSGML v1.0//EN";
    if ($number!=0) {
      // créer le fichier ICS
      foreach ($planning as $value) {
        $monICS .= "BEGIN:VEVENT
                    DTSTART:".$value['date']."
                    DTEND:".$value['date']."
                    SUMMARY:".$value['commentaire']."
                    END:VEVENT";
                    /* "DESCRIPTION:". à mettre les groupes liés à la date*/
      }
      $monICS .= "END:VCALENDAR";
      // écrire dans fichier
      $monfic = fopen("./ICS/tmp.ics", "w");
      fwrite($monfic, $monICS);
      fclose($monfic);
      $this->telechargerICS();
    }
  }

  function telechargerICS() {
                header("Content-type: application/octet-stream");
                header("Content-type: application/octet-stream");
            header("Content-length: ./ICS/tmp.ics");
            header("Cache-control: private");
    //header('location: ./ICS/tmp.ics');
  }
}
?>
