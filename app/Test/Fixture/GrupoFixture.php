<?php
/* Grupo Fixture generated on: 2012-01-16 11:22:45 : 1326723765 */

/**
 * GrupoFixture
 *
 */
class GrupoFixture extends CakeTestFixture {

	/**
	 * Import
	 *
	 * @var array
	 */
	public $import = array( 'model' => 'Grupo' );

    /**
     * Inicailización de datos dinamicos
     */
    public function init() {
        $this->records[] = array( 'id_grupo' => 1, 'nombre' => 'Administradores' );
        $this->records[] = array( 'id_grupo' => 2, 'nombre' => 'Medicos'         );
        $this->records[] = array( 'id_grupo' => 3, 'nombre' => 'Secretarias'     );
        $this->records[] = array( 'id_grupo' => 4, 'nombre' => 'Pacientes'       );
        parent::init();
    }
}
