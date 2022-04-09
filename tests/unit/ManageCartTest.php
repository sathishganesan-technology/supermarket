<?php

use PHPUnit\Framework\TestCase;

include_once('./dbmanager/databasebmanager.php');
include_once('./cartmanager.php');

class ManageCartTest extends Testcase {

    private $db_connection;

    protected function setUp(): void {
        $this->db_connection = new DatabaseManager();
    }

    public function testdependencyOffer(): void {
        $service = $this->createMock(Cartmanager::class);
        $service
                ->expects(self::once())
                ->method('dependencyOffer')
                ->willReturn(15.00);
        self::assertIsFloat($service->dependencyOffer('4', '1'));
    }

    public function testPositiveTestcase() {

        $expected = "test";
        $actual = "test";

        $this->assertEquals(
                $expected,
                $actual,
                "Actual value is  equal as expected"
        );
    }

    public function testPositiveTestcaseForAssertCount() {
        $testArray = array(1, 2, 3, 4);
        $expectedCount = 4;
        $this->assertCount(
                $expectedCount,
                $testArray, "Array contains 3 elements"
        );
    }

    public function testValidDBControllerInstance(): void {
        $this->assertInstanceOf(DatabaseManager::class, new DatabaseManager);
    }

    protected function tearDown(): void {
        $this->db_handle = null;
    }

}
