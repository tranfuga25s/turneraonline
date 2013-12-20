<?php
/* Secretaria Fixture generated on: 2012-01-18 19:17:09 : 1326925029 */

/**
 * SecretariaFixture
 *
 */
class SecretariaFixture extends CakeTestFixture {

	public $import = array( 'table' => 'secretarias' );

    public function init() {
        $this->records[] = array(
                'id_secretaria' => 1,
                'usuario_id' => 2,
                'clinica_id' => 1,
                'resumen' => true
        );
        parent::init();
    }
}
