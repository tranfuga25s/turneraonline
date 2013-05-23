<?php
/**
 * Clase para ejecutar todos los test
 */
class AllComponentsTests extends PHPUnit_Framework_TestSuite {

    /**
     * Suite define the tests for this suite
     *
     * @return $suite
     */
	public static function suite() {
		$suite = new PHPUnit_Framework_TestSuite('All Components Tests');
        $path = APP_TEST_CASES . DS . 'Controller' . DS . 'Component'. DS;
        $suite->addTestFile( $path.'DiaTurnoRecallComponentTest.php' );
        $suite->addTestFile( $path.'AutoUpdateRecallComponentTest.php' );
		return $suite;
	}
}
