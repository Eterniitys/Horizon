<?php 
namespace app;
include 'utils.php';

class Concert{
	private $_id_concert;
	private $_date_evenement;
	private $_lieu;
	private $_place;
	private $_place_libre;
	private $_prix;
	private $_description;
	
	public function __construct(array $table){
		$this->hydrate($table);
	}
	
	public function hydrate(array $data){
		foreach($data as $k=>$v){
			$method='set'.ucfirst($k);
			if(method_exists($this,$method)){
				$this->$method($v);
			}
		}
	}
	
	/**
	 * Get from database/concerts tuple id: $id
	 */
	public static function getDBconcert($id=-1){
		$db = dbConnexion();
		$prep = $db->prepare("select * from concerts where id_concert=:id" );
		$prep->execute(array('id'=>$id));
		$array = $prep->fetch(\PDO::FETCH_ASSOC);
		if ($array){
			return new Concert($array);
		}else{
			return new Concert(array());
		}
	}
	
	/**
	 * Update instance in database
	 */
	public function update(){
		$db = dbConnexion();
		$prep = $db->prepare("update concerts set date_evenement=:date,lieu=:lieu, place=:place, place_libre=:place_l, prix=:prix, description=:desc where id_concert=:id" );
		$prep->execute(array('date'=>$this->getDate_evenement(),
					 'lieu'=>$this->getLieu(),
					 'place'=>$this->getPlace(),
					 'place_l'=>$this->getPlace_libre(),
					 'prix'=>$this->getPrix(),
					 'desc'=>$this->getDescription(),
					 'id'=>$this->getId_concert()
					 )
				);
	}
	
	/**
	 * Add instance to database
	 */
	public function add(){
		$db = dbConnexion();
		$prep = $db->prepare("insert into concerts(date_evenement,lieu,place, place_libre, prix, description) values (:date,:lieu,:place,:place_l,:prix,:desc)" );
		$prep->execute(array('date'=>$this->getDate_evenement(),
					 'lieu'=>$this->getLieu(),
					 'place'=>$this->getPlace(),
					 'place_l'=>$this->getPlace_libre(),
					 'prix'=>$this->getPrix(),
					 'desc'=>$this->getPrix()
					 )
				);
	}
	
	/**
	 * Delete instance from database
	 */
	public function delete(){
		$db = dbConnexion();
		$prep = $db->prepare("delete from concerts where id_concert=:id" );
		$prep->execute(array('id'=>$this->getId_concert()));
	}
	
	
	/**
	 * Moderate the number of free places in database by: $nb
	 */
	public function modFrPl($nb){
		$this->setPlace_libre($this->getPlace_libre()+$nb);
	}
	
	public function setId_concert($id){ $this->_id_concert = $id; }
	public function setDate_evenement($date){ $this->_date_evenement = $date; }
	public function setLieu($lieu){ $this->_lieu = $lieu; }
	public function setPlace($place){ $this->_place = $place; }
	public function setPlace_libre($place){ $this->_place_libre = $place; }
	public function setPrix($prix){ $this->_prix = $prix; }
	public function setDescription($desc){ $this->_description = $desc; }
	
	public function getId_concert(){ return $this->_id_concert; }
	public function getDate_evenement(){ return $this->_date_evenement; }
	public function getLieu(){ return $this->_lieu; }
	public function getPlace(){ return $this->_place; }
	public function getPlace_libre(){ return $this->_place_libre; }
	public function getPrix(){ return $this->_prix; }
	public function getDescription(){ return $this->_description; }
}
?>
