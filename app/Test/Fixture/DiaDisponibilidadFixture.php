<?php
/**
 * DiaDisponibilidadFixture
 *
 */
class DiaDisponibilidadFixture extends CakeTestFixture {

	/**
	 * Import
	 *
	 * @var array
	 */
	public $import = array('model' => 'DiaDisponibilidad' );

	public function init() {
	   $this->records[] = array(
	       'id' => 1,
	       'disponibilidad_id' => 1,
	       'dia' => 1,
	       'habilitado' => true,
	       'hora_inicio' => '08:00:00',
	       'hora_fin' => '12:00:00',
	       'hora_inicio_tarde' => '14:00:00',
	       'hora_fin_tarde' => '18:00:00'
       );
       $this->records[] = array(
           'id' => 2,
           'disponibilidad_id' => 1,
           'dia' => 2,
           'habilitado' => true,
           'hora_inicio' => '08:00:00',
           'hora_fin' => '12:00:00',
           'hora_inicio_tarde' => '14:00:00',
           'hora_fin_tarde' => '18:00:00'
       );
       $this->records[] = array(
           'id' => 3,
           'disponibilidad_id' => 1,
           'dia' => 3,
           'habilitado' => true,
           'hora_inicio' => '08:00:00',
           'hora_fin' => '12:00:00',
           'hora_inicio_tarde' => '14:00:00',
           'hora_fin_tarde' => '18:00:00'
       );
       $this->records[] = array(
           'id' => 4,
           'disponibilidad_id' => 1,
           'dia' => 4,
           'habilitado' => true,
           'hora_inicio' => '08:00:00',
           'hora_fin' => '12:00:00',
           'hora_inicio_tarde' => '14:00:00',
           'hora_fin_tarde' => '18:00:00'
       );
       $this->records[] = array(
           'id' => 5,
           'disponibilidad_id' => 1,
           'dia' => 5,
           'habilitado' => true,
           'hora_inicio' => '08:00:00',
           'hora_fin' => '12:00:00',
           'hora_inicio_tarde' => '14:00:00',
           'hora_fin_tarde' => '18:00:00'
       );
       parent::init();
	}

}
