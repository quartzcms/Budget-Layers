<?php 
	try {
	  $dns = 'mysql:host='.$bg_host.';dbname='.$bg_db_name;
	  // Options de connection
	  $options = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	  );
	  $bg_connexion = new PDO( $dns, $bg_user, $bg_password, $options );
	} catch ( Exception $e ) {
	  echo "Connection à MySQL impossible : ", $e->getMessage();
	  die();
	}
?>