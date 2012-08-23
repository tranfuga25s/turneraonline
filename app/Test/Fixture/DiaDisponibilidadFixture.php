<?php
/* DiaDisponibilidad Fixture generated on: 2012-03-13 21:58:35 : 1331686715 */

/**
 * DiaDisponibilidadFixture
 *
 */
class DiaDisponibilidadFixture extends CakeTestFixture {
/**
 * Table name
 *
 * @var string
 */
	public $table = 'dia_disponibilidad';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'disponibilidad_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'dia' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 6, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'habilitado' => array('type' => 'boolean', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'hora_inicio' => array('type' => 'time', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'hora_fin' => array('type' => 'time', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'hora_inicio_tarde' => array('type' => 'time', 'null' => true, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'hora_fin_tarde' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'indexes' => array('PRIMARY' => array('column' => array('disponibilidad_id', 'dia'), 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'disponibilidad_id' => 1,
			'dia' => 1,
			'habilitado' => 1,
			'hora_inicio' => '21:58:35',
			'hora_fin' => '21:58:35',
			'hora_inicio_tarde' => '21:58:35',
			'hora_fin_tarde' => 1
		),
	);
}
