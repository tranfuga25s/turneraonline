<?php
/* Excepcione Fixture generated on: 2012-02-01 23:26:39 : 1328149599 */

/**
 * ExcepcioneFixture
 *
 */
class ExcepcionFixture extends CakeTestFixture {

    public $table = 'test_excepciones';

    /**
     * Fields
     *
     * @var array
     */
	public $fields = array(
		'id_excepcion' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'key' => 'primary', 'collate' => NULL, 'comment' => ''),
		'medico_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 20, 'collate' => NULL, 'comment' => ''),
		'inicio' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'fin' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'collate' => NULL, 'comment' => ''),
		'indexes' => array('PRIMARY' => array('column' => 'id_excepcion', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish_ci', 'engine' => 'InnoDB')
	);

    /**
     * Records
     *
     * @var array
     */
	public $records = array(
		array(
			'id_excepcion' => 1,
			'medico_id' => 1,
			'inicio' => '2012-02-01 23:26:39',
			'fin' => '2012-02-01 23:26:39'
		),
	);
}
