<?php
	require_once 'AccessLogAPI.php';
	require_once 'MockPDO.php';

	require_once 'MockStatement.php';
	class AccessLogAPITest extends PHPUnit_Framework_TestCase {
		function setUp() {
			$this->mockPDOStatement = $this->getMock('MockStatement');
			$this->mockPDO = $this->getMock('MockPDO');
			$this->accessLogAPI = new AccessLogAPI();
		}
		function testInsert() {
			$object = new AccessLogAPI();
			$dbh = new PDO('mysql:host=localhost;dbname=access_log', 'root', '1234');
			$object->setPDO($dbh);
			$result = $object->insert(null);
			$this->assertTrue($result);
		}

		function testInsertMockSuccess() {
			$this->mockPDOStatement->expects($this->exactly(1))
             ->method('execute')
             ->will($this->returnValue(true));

			$this->mockPDO->expects($this->exactly(1))
             ->method('prepare')
             ->will($this->returnValue($this->mockPDOStatement));

			$this->accessLogAPI->setPDO($this->mockPDO);
			$result = $this->accessLogAPI->insert(null);
			$this->assertTrue($result);
		}
		function testInsertMockFail() {
			$this->mockPDOStatement->expects($this->exactly(1))
             ->method('execute')
             ->will($this->returnValue(false));
            
			$this->mockPDO->expects($this->exactly(1))
             ->method('prepare')
             ->will($this->returnValue($this->mockPDOStatement));

			$this->accessLogAPI->setPDO($this->mockPDO);
			$result = $this->accessLogAPI->insert(null);
			$this->assertFalse($result);
		}

		function testDelete(){

			$this->mockPDOStatement->expects($this->once())
						  ->method('execute');

			$this->mockPDOStatement->expects($this->once())
						  ->method('rowCount')
						  ->will($this->returnValue(1));

			$this->mockPDO->expects($this->once())
				 ->method('prepare')
				 ->will($this->returnValue($this->mockPDOStatement));


			$this->accessLogAPI->setPDO($this->mockPDO);
			$result = $this->accessLogAPI->deleteById(1);

			$this->assertEquals($result, 1);
		}

		function testUpdate1Row() {


			$expected = 1;
			
			$stubPDOStmt = $this->mockPDOStatement;
			$stubPDOStmt->expects($this->once())
				->method('execute')
				->will($this->returnValue(true));
			$stubPDOStmt->expects($this->once())
				->method('rowCount')
				->will($this->returnValue(1));
			
			
			$stubPDO = $this->mockPDO;
			$stubPDO->expects($this->once())
				->method('setAttribute');
			$stubPDO->expects($this->once())
				->method('prepare')
				->will($this->returnValue($stubPDOStmt));
			
			$accessLogAPI = $this->accessLogAPI;
			$accessLogAPI->setPDO($stubPDO);
			
			$id = 1;
			$keys = array("service_name");
			$values = array("AccessLogAPI");
			$result = $accessLogAPI->updateById($id, $keys, $values);
			
			
			$this->assertEquals($expected, $result);
		}
}

?>