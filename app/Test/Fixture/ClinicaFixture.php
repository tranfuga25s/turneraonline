<?php

/**
 * ClinicaFixture
 *
 */
class ClinicaFixture extends CakeTestFixture {

    /**
     * Import
     *
     * @var array
     */
    public $import = array('table' => 'clinicas');

    /**
     * Inicailización de datos dinamicos
     */
    public function init() {
        parent::init();
        $this->records[] = array(
            'id_clinica' => 1,
            'nombre' => 'Clinica de Prueba',
            'direccion' => 'Dirección de prueba',
            'telefono' => 2147483647,
            'email' => 'clinica.prueba@gmail.com',
            'logo' => '',
            'lat' => -31.63381943104241,
            'lng' => -60.69901466369629,
            'zoom' => 15
        );
    }

}
