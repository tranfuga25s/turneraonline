<?php
/* Turno Fixture generated on: 2012-01-16 12:03:30 : 1326726210 */

/**
 * TurnoFixture
 *
 */
class TurnoFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id_turno' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'paciente_id' => array('type' => 'integer', 'null' => true, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'medico_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'fecha_inicio' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'fecha_fin' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'consultorio_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'recibido' => array('type' => 'boolean', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'atendido' => array('type' => 'boolean', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'cancelado' => array('type' => 'boolean', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'indexes' => array('PRIMARY' => array('column' => 'id_turno', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array( 'id_turno' => 1, 'paciente_id' => null, 'medico_id' => 1, 'fecha_inicio' => '2012-01-16 12:03:30', 'fecha_fin' => '2012-01-16 12:03:40', 'consultorio_id' => 1,	'recibido' => false, 'atendido' => false, 'cancelado' => false ),
		array( 'id_turno' => 2, 'paciente_id' => 1   , 'medico_id' => 1, 'fecha_inicio' => '2012-07-16 12:03:30', 'fecha_fin' => '2012-07-16 12:03:40', 'consultorio_id' => 1,	'recibido' => false, 'atendido' => false, 'cancelado' => false ),
		array( 'id_turno' => 3, 'paciente_id' => 1   , 'medico_id' => 1, 'fecha_inicio' => '2012-09-16 12:03:30', 'fecha_fin' => '2012-09-16 12:03:40', 'consultorio_id' => 1,	'recibido' => false, 'atendido' => false, 'cancelado' => false ),
		array( 'id_turno' => 4, 'paciente_id' => null, 'medico_id' => 1, 'fecha_inicio' => '2012-09-17 12:03:30', 'fecha_fin' => '2012-09-17 12:03:40', 'consultorio_id' => 1,	'recibido' => false, 'atendido' => false, 'cancelado' => false )
	);
}
