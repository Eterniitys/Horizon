<?php
if (!defined('_UTILS_')){
	define('_UTILS_',true);

	function dbConnexion(){
		if(!defined('_CONNEC_')){
			define ('_CONNEC_',true);
			include "connexion_postgres.php";
		}
		return connexion();
	}

	function no_spaces($string) {
		return str_replace(" ","_",$string);
	}

	function start_session_once() {
		if (!isset($_SESSION))
			session_start();
	}

	function redirect($url,$time=0) {
		//permet l'affichage de message avant une redirection
		echo "<meta http-equiv=\"refresh\" content=\"$time; URL=$url\" />";
		exit();
	}

	function preTab($table){
		echo '<pre>';
		print_r($table);
		echo '</pre>';
	}

	function make_safe_array($table){
		if (is_array($table)){
			foreach ($table as $k=>$v){
				$array[$k] = htmlspecialchars($v); 
			}
		}else{
			$array=array();
		}
		return $array;
	}

	function message($message){
		echo "<script>alert('$message')</script>" ;
	}
	
	function dateFr($date=-1){
		setlocale(LC_TIME, 'fr_FR.utf8','fra');
		if ($date == -1){
			$date=time();
			return strftime("%d %B %Y",strtotime(date('d M Y',$date)));
		}
		return strftime("%d %B %Y",strtotime($date));
	}
}
?>
