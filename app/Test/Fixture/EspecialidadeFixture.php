<?php
/* Especialidade Fixture generated on: 2012-01-11 19:32:21 : 1326321141 */

/**
 * EspecialidadeFixture
 *
 */
class EspecialidadeFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id_especialidad' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'nombre' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'utf8_spanish_ci', 'comment' => '', 'charset' => 'utf8'),
		'indexes' => array('PRIMARY' => array('column' => 'id_especialidad', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id_especialidad' => 1,
			'nombre' => 'Lorem ipsum dolor sit amet'
		),
	);
}
