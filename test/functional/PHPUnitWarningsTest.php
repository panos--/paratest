<?php

/**
 * Specifically tests warnings when using PHPUnit 4.8 and below
 */
class PHPUnitWarningsTest extends FunctionalTestBase
{
    public function testTestsWithWarningsResultInFailure()
    {
        $proc = $this->invokeParatest(
            "warning-tests/HasWarningsTest.php",
            array('bootstrap' => BOOTSTRAP)
        );

        $output = $proc->getOutput();

        if (version_compare(PHP_VERSION, '5.6.0', '>=')) {
            // PHPUnit 5.1+ Changed how it handles test warnings (not E_WARNINGS)
            $this->assertContains("Warnings", $output, "Test should output warnings");
            $this->assertEquals(0, $proc->getExitCode(), "Test suite should succeed with 0");
        } else {
            // PHPUnit 4.8 and below failed the test suite if a test warning occurred
            $this->assertEquals(1, $proc->getExitCode(), "Test suite should fail with 1");
        }
    }
}
