<?php
trait Database {
	public function db_connect() {
		$this->db = new mysqli('IP', 'UtilizadorBD', 'PasswordBD', 'BD');
		$this->db->set_charset("utf8");
		if (mysqli_connect_error()) {
			return false;
		} else {
			return true;
		}
	}
}
?>