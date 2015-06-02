<?php

class Home_Model extends Model {

   public function __construct(){
      parent::__construct();
   }

   /**
   * Show last 20 items in database
   */
   public function all() {
      return $this->_db->select('SELECT * FROM new_releases ORDER BY id ASC LIMIT 0, 16');
   }
   public function insert($data) {
     $this->_db->insert('new_releases', $data);
   }
   public function check($datac) {
   	 return $this->_db->select("SELECT COUNT(*) AS num_rows FROM new_releases WHERE movie_title = '$datac'");
   }
}