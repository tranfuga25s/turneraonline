<?php
/* Usuario Fixture generated on: 2012-01-12 11:36:19 : 1326378979 */

/**
 * UsuarioFixture
 *
 */
class UsuarioFixture extends CakeTestFixture {

	/**
	 * Import
	 *
	 * @var array
	 */
	public $import = array( 'model' => 'Usuario' );

    /**
     * Inicailización de datos dinamicos
     */
    public function init() {
        $this->records[] = array(
                'id_usuario' => 1,
                'email' => 'esteban.zeller@gmail.com',
                'nombre' => 'Esteban Javier',
                'apellido' => 'Zeller',
                'telefono' => '09432049',
                'celular' => 304923049,
                'obra_social_id' => 1,
                'notificaciones' => 1,
                'grupo_id' => 1,
                'facebook_id' => 0,
                'sexo' => 'm'
        );
        $this->records[] = array(
                'id_usuario' => 2,
                'email' => 'esteban.zeller@gmail.com',
                'nombre' => 'Esteban Javier',
                'apellido' => 'Zeller',
                'telefono' => 09432049,
                'celular' => 304923049,
                'obra_social_id' => 1,
                'notificaciones' => 1,
                'grupo_id' => 1,
                'facebook_id' => 0,
                'sexo' => 'm'
        );
        parent::init();
    }
}
