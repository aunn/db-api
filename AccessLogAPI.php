<?php
class AccessLogAPI {

	function setPDO($db) {
		$this->db = $db;
	}
	
	
	function updateById($id, $keys, $values){
			$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$update = "";
			foreach($keys as $key) {
				if($update!="") $update .= ", ";
				$update .= $key."=?";
			}
			$stmt = $this->db->prepare("UPDATE api_log SET ".$update." where id=?");
			$params = array_merge($values, array($id));

			$stmt->execute($params);

			return  $stmt->rowCount();

	}
}
?>