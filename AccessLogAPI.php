<?php
class AccessLogAPI {

	function setPDO($db) {
		$this->db = $db;
	}
	
	function deleteById($id) {
		$db = $this->db;
		$stmt = $db->prepare("DELETE FROM api_log WHERE id = ?");
		$stmt->execute(array($id));
		return $stmt->rowCount();
		return 1;
	}
	
}
?>