<?php
/**
 * AvisoFixture
 *
 */
class AvisoFixture extends CakeTestFixture {

    /**
     * Import
     *
     * @var array
     */
	public $import = array('model' => 'Aviso');

    /**
     * Records
     *
     * @var array
     */
	public $records = array(
		array(
			'id_aviso' => '32',
			'fecha_envio' => '2013-05-22 03:00:00',
			'template' => 'nuevoTurno',
			'layout' => 'usuario',
			'formato' => 'both',
			'to' => 'vane.apablaza@gmail.com',
			'from' => 'test@alejandrotanin.com.ar',
			'subject' => 'Turno proximo',
			'metodo' => 'email'
		),
		array(
			'id_aviso' => '33',
			'fecha_envio' => '2013-05-21 20:00:00',
			'template' => 'nuevoTurno',
			'layout' => 'usuario',
			'formato' => 'both',
			'to' => 'tranfuga25s@gmail.com',
			'from' => 'test@alejandrotanin.com.ar',
			'subject' => 'Turno proximo',
            'metodo' => 'email'
		),
		array(
			'id_aviso' => '34',
			'fecha_envio' => '2013-05-28 20:00:00',
			'template' => 'nuevoTurno',
			'layout' => 'usuario',
			'formato' => 'both',
			'to' => 'paciente@turnera.com',
			'from' => 'test@alejandrotanin.com.ar',
			'subject' => 'Turno proximo',
            'metodo' => 'email'
		),
		array(
			'id_aviso' => '35',
			'fecha_envio' => '2013-06-04 20:00:00',
			'template' => 'nuevoTurno',
			'layout' => 'usuario',
			'formato' => 'both',
			'to' => 'daniels591@hotmail.com',
			'from' => 'test@alejandrotanin.com.ar',
			'subject' => 'Turno proximo',
            'metodo' => 'email'
		),
		array(
			'id_aviso' => '36',
			'fecha_envio' => '2013-06-03 17:00:00',
			'template' => 'nuevoTurno',
			'layout' => 'usuario',
			'formato' => 'both',
			'to' => 'admin@admin.com.ar',
			'from' => 'test@alejandrotanin.com.ar',
			'subject' => 'Turno proximo',
            'metodo' => 'email'
		),
		array(
			'id_aviso' => '37',
			'fecha_envio' => '2013-06-03 17:20:00',
			'template' => 'nuevoTurno',
			'layout' => 'usuario',
			'formato' => 'both',
			'to' => 'tranfuga25s@gmail.com',
			'from' => 'test@alejandrotanin.com.ar',
			'subject' => 'Turno proximo',
            'metodo' => 'email'
		),
		array(
			'id_aviso' => '38',
			'fecha_envio' => '2013-06-09 21:00:00',
			'template' => 'nuevoTurno',
			'layout' => 'usuario',
			'formato' => 'both',
			'to' => 'paciente@turnera.com',
			'from' => 'test@alejandrotanin.com.ar',
			'subject' => 'Turno proximo',
            'metodo' => 'email'
		),
		array(
			'id_aviso' => '39',
			'fecha_envio' => '2013-07-02 20:00:00',
			'template' => 'nuevoTurno',
			'layout' => 'usuario',
			'formato' => 'both',
			'to' => 'daniels591@hotmail.com',
			'from' => 'test@alejandrotanin.com.ar',
			'subject' => 'Turno proximo',
            'metodo' => 'email'
		),
		array(
			'id_aviso' => '40',
			'fecha_envio' => '2013-07-02 20:20:00',
			'template' => 'nuevoTurno',
			'layout' => 'usuario',
			'formato' => 'both',
			'to' => 'daniels591@gmail.com',
			'from' => 'test@alejandrotanin.com.ar',
			'subject' => 'Turno proximo',
            'metodo' => 'email'
		),
	);

}
