<?php
/**
 * Clase para ejecutar todos los test de modelos
 */
class AllModelTests extends PHPUnit_Framework_TestSuite {

    /**
     * Suite define the tests for this suite
     *
     * @return $suite
     */
    public static function suite() {
        $suite = new PHPUnit_Framework_TestSuite('Test de todos los modelos');
        $path = APP_TEST_CASES . DS . 'Model' . DS;
        $suite->addTestFile( $path.'AvisoTest.php' );
        $suite->addTestFile( $path.'ClinicaTest.php' );
        $suite->addTestFile( $path.'ConsultorioTest.php' );
        //$suite->addTestFile( $path.'DiaDisponibilidadTest.php' );
        $suite->addTestFile( $path.'EspecialidadTest.php' );
        //$suite->addTestFile( $path.'GrupoTest.php' );
        //$suite->addTestFile( $path.'MedicoTest.php' );
        //$suite->addTestFile( $path.'ObraSocialTest.php' );
        //$suite->addTestFile( $path.'SecretariaTest.php' );
        $suite->addTestFile( $path.'TurnoTest.php' );
        $suite->addTestFile( $path.'UsuarioTest.php' );
        return $suite;
    }
}
