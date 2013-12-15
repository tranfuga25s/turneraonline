<?php
/**
 * VariablesAvisoFixture
 *
 */
class VariableAvisoFixture extends CakeTestFixture {

    /**
     * Import
     *
     * @var array
     */
	public $import = array( 'model' => 'VariableAviso' );

    /**
     * Inicailización de datos dinamicos
     */
    public function init() {
        $this->records[] = array(
                'id_variable' => 1,
                'modelo' => 'Usuario',
                'id' => 1,
                'nombre' => 'usuario',
                'aviso_id' => 1
        );
        parent::init();
    }
}
