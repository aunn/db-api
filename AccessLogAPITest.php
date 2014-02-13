<?php
	require_once 'AccessLogAPI.php';
	require_once 'MockPDO.php';
	require_once 'MockStatement.php';

	class AccessLogAPITest extends PHPUnit_Framework_TestCase {
		function setUp() {
			$this->accessLogAPI = new AccessLogAPI();
		}

		function testDelete(){
			$stubPDO = $this->getMock('MockPDO');
			$stubStatement = $this->getMock('MockStatement');

			$stubStatement->expects($this->once())
						  ->method('execute');

			$stubStatement->expects($this->once())
						  ->method('rowCount')
						  ->will($this->returnValue(1));

			$stubPDO->expects($this->once())
				 ->method('prepare')
				 ->will($this->returnValue($stubStatement));


			$this->accessLogAPI->setPDO($stubPDO);
			$result = $this->accessLogAPI->deleteById(1);

			$this->assertEquals($result, 1);
		}
	}
?>