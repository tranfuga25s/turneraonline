<?php
/* Medico Fixture generated on: 2012-01-17 16:28:31 : 1326828511 */

/**
 * MedicoFixture
 *
 */
class MedicoFixture extends CakeTestFixture {

	public $import = array( 'model' => 'Medico' );

    /**
     * Inicailización de datos dinamicos
     */
    public function init() {
        $this->records[] = array(
                'id_medico' => 1,
                'usuario_id' => 3,
                'especialidad_id' => 1,
                'clinica_id' => 1,
                'visible' => true
        );
        $this->records[] = array(
                'id_medico' => 2,
                'usuario_id' => 4,
                'especialidad_id' => 2,
                'clinica_id' => 1,
                'visible' => false
        );
        $this->records[] = array(
                'id_medico' => 3,
                'usuario_id' => 5,
                'especialidad_id' => 2,
                'clinica_id' => 1,
                'visible' => true
        );
        parent::init();
    }
}
