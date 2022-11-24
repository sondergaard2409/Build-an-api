<?php

class Artist {
     public $id;
     public $name;
     public $created_at;
     public $updated_at;


     private $db;



     public function __construct(){

          global $db;
          $this->db = $db;



     }
     public function list(){
          $limit = isset($_GET['limit']) ?
          $_GET['limit']:10; 
           $sql = "SELECT  name
                   FROM artist 
                   ORDER BY id 
                   LIMIT $limit";

     return $this->db->query($sql);
          }


     public function details($id) {
          $params = array(
               'id' => array($id, PDO::PARAM_INT)
          );
          // Jeg skal globalzer min $db hvere gang
          // global $db;
          $sql = "SELECT title,content, artist_id
                  FROM artist
                  WHERE id = :id";


          return $this->db->query($sql, $params);

    }

    public function create() {
		$params = array(
			'title' => array($this->title, PDO::PARAM_STR),
			'content' => array($this->content, PDO::PARAM_STR),
			'artist_id' => array($this->artist_id, PDO::PARAM_INT)
		);

		$sql = "INSERT INTO artist(title, content, artist_id) 
				VALUES(:title, :content, :artist_id)";
		$this->db->query($sql, $params);
		return $this->db->lastInsertId();
	}

	/**
	 * Metode til at opdatere en sang med
	 * Skal have sangens id med i form body
	 */
	public function update() {
		$params = array(
			'id' => array($this->id, PDO::PARAM_INT),
			'title' => array($this->title, PDO::PARAM_STR),
			'content' => array($this->content, PDO::PARAM_STR),
			'artist_id' => array($this->artist_id, PDO::PARAM_INT)
		);

		$sql = "UPDATE artist SET 
				title = :title,
				content = :content,
				artist_id = :artist_id 
				WHERE id = :id";

		return $this->db->query($sql, $params);
	}

	/**
	 * Metode til at slette en sang med
	 * @param id (int) Sangens id
	 */
	public function delete($id) {
		$params = array(
			'id' => array($id, PDO::PARAM_INT)
		);
		
		$sql = "DELETE FROM artist 
				WHERE id = :id";
		return $this->db->query($sql, $params);
	}
}





?>