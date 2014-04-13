<?php
/* ObrasSociale Fixture generated on: 2012-01-11 21:59:32 : 1326329972 */

/**
 * ObraSocialFixture
 *
 */
class ObraSocialFixture extends CakeTestFixture {

	/**
	 * Import
	 *
	 * @var array
	 */
	public $import = array( 'model' => 'ObraSocial' );
    
    /**
     * Inicializacion de los datos de pruebas
     */
    public function init() {
        $this->records[] = array(      
                'id_obra_social' => 1,
                'nombre' => 'Obra social 1',
                'direccion' => 'Direccion 1',
                'telefono' => 302930493820,
                'imagen' => 'vacio.png'     
        );
        $this->records[] = array(      
                'id_obra_social' => 2,
                'nombre' => 'Obra social 2',
                'direccion' => 'Direccion 2',
                'telefono' => 302930493850,
                'imagen' => 'vacio.png'     
        );
        parent::init();
    }
}
