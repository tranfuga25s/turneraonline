<?php
/* Medico Fixture generated on: 2012-01-17 16:28:31 : 1326828511 */

/**
 * MedicoFixture
 *
 */
class MedicoFixture extends CakeTestFixture {

	public $import = array( 'modelo' => 'Medico' );


    /**
     * Inicailización de datos dinamicos
     */
    public function init() {
        $this->records[] = array(
                'id_medico' => 1,
                'id_usuario' => 1,
                'id_especialidad' => 1,
                'clinica_id' => 1,
                'visible' => 1
        );
        $this->records[] = array(
                'id_medico' => 2,
                'id_usuario' => 2,
                'id_especialidad' => 2,
                'clinica_id' => 1,
                'visible' => 1
        );
        parent::init();
    }
}
