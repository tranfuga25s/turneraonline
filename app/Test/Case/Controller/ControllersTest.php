<?php
/**
 * Clase para ejecutar todos los test
 */
class ControllersTests extends PHPUnit_Framework_TestSuite {

    /**
     * Suite define the tests for this suite
     *
     * @return $suite
     */
	public static function suite() {
		$suite = new PHPUnit_Framework_TestSuite('All Controller Tests');
        $path = APP_TEST_CASES . DS . 'Controller' . DS;
        $suite->addTestFile( $path.'ClinicasControllerTest.php' );
		return $suite;
	}
}
