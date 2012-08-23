<?php
/* Disponibilidad Fixture generated on: 2012-01-18 19:16:00 : 1326924960 */

/**
 * DisponibilidadFixture
 *
 */
class DisponibilidadFixture extends CakeTestFixture {
/**
 * Table name
 *
 * @var string
 */
	public $table = 'disponibilidad';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id_disponibilidad' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'medico_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'collate' => NULL, 'comment' => ''),
		'hora_inicio' => array('type' => 'time', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'hora_fin' => array('type' => 'time', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'lunes' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'collate' => NULL, 'comment' => ''),
		'martes' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'collate' => NULL, 'comment' => ''),
		'miercoles' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'collate' => NULL, 'comment' => ''),
		'jueves' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'collate' => NULL, 'comment' => ''),
		'viernes' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'collate' => NULL, 'comment' => ''),
		'sabado' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'collate' => NULL, 'comment' => ''),
		'domingo' => array('type' => 'boolean', 'null' => false, 'default' => '0', 'collate' => NULL, 'comment' => ''),
		'indexes' => array('PRIMARY' => array('column' => 'id_disponibilidad', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id_disponibilidad' => 1,
			'medico_id' => 1,
			'hora_inicio' => '19:16:00',
			'hora_fin' => '19:16:00',
			'lunes' => 1,
			'martes' => 1,
			'miercoles' => 1,
			'jueves' => 1,
			'viernes' => 1,
			'sabado' => 1,
			'domingo' => 1
		),
	);
}
