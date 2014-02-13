<?php
	require_once 'AccessLogAPI.php';
	require_once 'MockPDO.php';
	class AccessLogAPITest extends PHPUnit_Framework_TestCase {
		function testUpdate1Row() {
			$expected = 1;
			
			$stubPDOStmt = $this->getMock('PDOStatement');
			$stubPDOStmt->expects($this->once())
				->method('execute')
				->will($this->returnValue(true));
			$stubPDOStmt->expects($this->once())
				->method('rowCount')
				->will($this->returnValue(1));
			
			
			$stubPDO = $this->getMock('MockPDO');
			$stubPDO->expects($this->once())
				->method('setAttribute');
			$stubPDO->expects($this->once())
				->method('prepare')
				->will($this->returnValue($stubPDOStmt));
			
			$accessLogAPI = new AccessLogAPI();	
			$accessLogAPI->setPDO($stubPDO);
			
			$id = 1;
			$keys = array("service_name");
			$values = array("AccessLogAPI");
			$result = $accessLogAPI->updateById($id, $keys, $values);
			
			
			$this->assertEquals($expected, $result);
		}
	}
?>