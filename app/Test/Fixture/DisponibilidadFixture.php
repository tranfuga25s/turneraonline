<?php

/* Disponibilidad Fixture generated on: 2012-01-18 19:16:00 : 1326924960 */

/**
 * DisponibilidadFixture
 *
 */
class DisponibilidadFixture extends CakeTestFixture {

    /**
     * Import
     *
     * @var array
     */
    public $import = array( 'model' => 'Disponibilidad' );

    public function init() {
        $this->records[] = array(
            'id_disponibilidad' => 1,
            'medico_id' => 3,
            'duracion' => 20,
            'consultorio_id' => 1
        );
        parent::init();
    }

}
