<?php

class Model_Example extends PHPSFW_Model {
	
	public function getUser($user_id) {
		// Example for mysql
		$data = $this->query("SELECT * FROM `tbl_users` WHERE `user_id` = '" . $user_id . "';")->fetch_object();
		return $data;
		
		// Example for mongo
		$data = $this->db->users->find(array("user_id"=>$user_id));
		return iterator_to_array($data);

	}
	
}