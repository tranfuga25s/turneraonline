<?php
/* Especialidade Fixture generated on: 2012-01-11 19:32:21 : 1326321141 */

/**
 * EspecialidadeFixture
 *
 */
class EspecialidadFixture extends CakeTestFixture {

    public $table = 'test_especialidades'; // INTRESANTE!

	/**
	 * Import
	 *
	 * @var array
	 */
	public $import = array( 'model' => 'Especialidad' );

    /**
     * Inicailización de datos dinamicos
     */
    public function init() {
        $this->records[] = array(
                'id_especialidad' => 1,
                'nombre' => 'Ginecología'
        );
        $this->records[] = array(
                'id_especialidad' => 2,
                'nombre' => 'Otorrinolaringología'
        );
        parent::init();
    }
}
