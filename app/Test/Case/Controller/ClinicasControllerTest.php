<?php
/* Clinicas Test cases generated on: 2012-01-11 19:08:59 : 1326319739*/
App::uses('ClinicasController', 'Controller');
App::uses('Clinica', 'Model' );

/**
 * TestClinicasController
 */
class TestClinicasController extends ClinicasController {
    /**
     * Auto render
     *
     * @var boolean
     */
    public $autoRender = false;

    /**
     * Redirect action
     *
     * @param mixed $url
     * @param mixed $status
     * @param boolean $exit
     * @return void
     */
    public function redirect($url, $status = null, $exit = true) {
        $this->redirectUrl = $url;
    }
}

/**
 * ClinicasController Test Case
 *
 */
class ClinicasControllerTestCase extends ControllerTestCase {
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array( 'app.clinica', 'app.consultorio', 'app.medico', 'app.secretaria', 'app.usuario', 'app.especialidad' );

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();

        $this->Clinicas = new TestClinicasController();
        $this->Clinicas->constructClasses();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown() {
        unset($this->Clinicas);

        parent::tearDown();
    }

    /**
     * testIndex method
     * Verifica que tenga la variable seteada
     * y que la variable no tenga datos recursivos innecesarios
     * @return void
     */
    public function testIndex() {
        $this->testAction( '/clinicas/index' );
        $this->assertInternalType( 'array', $this->vars['clinicas'], 'La vista no tiene definido su listado' );
        $this->assertNotEqual( count( $this->vars['clinicas'] ), 0, 'No hay ninguna clínica activa' );
        foreach( $this->vars['clinicas'] as $clinica ) {
            $this->assertNotEqual( array_key_exists( 'Medicos', $clinica ), true, 'El listado de clinicas posee los médicos relacionados' );
            $this->assertNotEqual( array_key_exists( 'Secretarias', $clinica ), true, 'El listado de clinicas posee los médicos relacionados' );
            $this->assertNotEqual( array_key_exists( 'Consultorios', $clinica ), true, 'El listado de clinicas posee los médicos relacionados' );
            //$this->assertNotEqual( $clinica['Clinica']['publicado'], false, 'El listado está mostrando una clinica no publicada' );
        }
    }

    /**
     * testView method
     *
     * @return void
     */
    public function testView() {
        $this->Clinica = new Clinica();
        $data = $this->Clinica->find( 'first', array( 'fields' => array( 'id_clinica' ), 'recursive' => -1 ) );
        $id_clinica = $data['Clinica']['id_clinica'];
        unset( $data );
        unset( $this->Clinica );
        $result = $this->testAction( '/clinicas/view/'.$id_clinica );
        $this->assertInternalType( 'array', $this->vars['clinica'], 'La vista no tiene definido sus datos en la variable clinica' );
        // Verifico que exista las coordenadas
        $this->assertNotEqual( $this->vars['clinica']['Clinica']['lat'], null, 'La coordenada de latitud no puede ser nula' );
        $this->assertNotEqual( $this->vars['clinica']['Clinica']['lng'], null, 'La coordenada de longitud no puede ser nula' );
    }

    /**
     * Función que prueba la vista de clinica cuando no se pasa ningún elemento para ver.
     * Debería de cargar la primera clínica que encuentre.
     */
    public function testViewEmptyParameter() {
        $result = $this->testAction( '/clinicas/view' );
        $this->assertInternalType( 'array', $this->vars['clinica'], 'La vista no tiene definido sus datos en la variable clinica cuando no se pasa parámetro' );
    }

    /**
     * testAdministracionIndex method
     *
     * @return void
     */
    public function testAdministracionIndex() {
        $this->testAction( '/administracion/clinicas/index' );
        $this->assertInternalType( 'array', $this->vars['clinicas'], 'La vista no tiene definido su listado' );
        $this->assertNotEqual( count( $this->vars['clinicas'] ), 0, 'No hay ninguna clínica activa' );
        foreach( $this->vars['clinicas'] as $clinica ) {
            $this->assertNotEqual( array_key_exists( 'Medicos', $clinica ), true, 'El listado de clinicas posee los médicos relacionados' );
            $this->assertNotEqual( array_key_exists( 'Secretarias', $clinica ), true, 'El listado de clinicas posee los médicos relacionados' );
            $this->assertNotEqual( array_key_exists( 'Consultorios', $clinica ), true, 'El listado de clinicas posee los médicos relacionados' );
            //$this->assertNotEqual( $clinica['Clinica']['publicado'], false, 'El listado está mostrando una clinica no publicada' );
        }
    }

    /**
     * testAdministracionView method
     *
     * @return void
     */
    public function testAdministracionView() {
        $this->Clinica = new Clinica();
        $data = $this->Clinica->find( 'first', array( 'fields' => array( 'id_clinica' ), 'recursive' => -1 ) );
        $id_clinica = $data['Clinica']['id_clinica'];
        unset( $data );
        unset( $this->Clinica );
        $result = $this->testAction( '/administracion/clinicas/view/'.$id_clinica );
        $this->assertInternalType( 'array', $this->vars['clinica'], 'La vista no tiene definido sus datos en la variable clinica' );
        // Verifico que exista las coordenadas
        $this->assertNotEqual( $this->vars['clinica']['Clinica']['lat'], null, 'La coordenada de latitud no puede ser nula' );
        $this->assertNotEqual( $this->vars['clinica']['Clinica']['lng'], null, 'La coordenada de longitud no puede ser nula' );
        // @TODO Verifico que cargue el helper de los mapas
    }

    /**
     * testAdministracionViewNonExistent method
     *
     * @return void
     */
    public function testAdministracionViewNonExistent() {
/*        $this->Clinica = $this->generate( 'Clinicas', array(
                'methods' => array( 'view' ) ) );

        $this->Clinica->will( $this->testAction( '/clinicas/view/-1' ),
                              $this->throwException( new NotFoundException() ) );*/
    }

    /**
     * testAdministracionAdd method
     *
     * @return void
     */
    public function testAdministracionAdd() {
        // Pruebo envío por get
        /*$result = $this->testAction( '/administracion/clinicas/add', array( 'method' => 'get' ) );
        $this->assertEqual( $result, true, "Salida:" .print_r( $result, true ) );*/
    }

    /**
     * testAdministracionEdit method
     *
     * @return void
     */
   /* public function testAdministracionEdit() {
        $this->assertEqual( false, true, "No implementado!" );
    }*/

    /**
     * testAdministracionDelete method
     *
     * @return void
     */
    /*public function testAdministracionDelete() {
        $this->assertEqual( false, true, "No implementado!" );
    }*/

}
