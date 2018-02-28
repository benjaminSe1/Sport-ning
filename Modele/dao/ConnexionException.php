<?php


class ConnexionException extends PDOException
{

	private $chaine;

	public function __construct($chaine)
	{
		$this->chaine=$chaine;
	}

	public function afficherMessage()
	{
		return $this->chaine;
	}

}

?>
