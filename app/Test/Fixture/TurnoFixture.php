<?php

/**
 * TurnoFixture
 *
 */
class TurnoFixture extends CakeTestFixture {

    /**
     * Import
     *
     * @var array
     */
    public $import = array('model' => 'Turno');

    public function init() {
        $this->records[] = array(
			'id_turno' => '2',
			'paciente_id' => null,
			'medico_id' => '1',
			'fecha_inicio' => '2012-10-09 08:20:00',
			'fecha_fin' => '2012-10-09 08:40:00',
			'consultorio_id' => '1',
			'recibido' => 0,
			'atendido' => 0,
			'cancelado' => 0
		);
		$this->records[] = array(
			'id_turno' => '3',
			'paciente_id' => null,
			'medico_id' => '1',
			'fecha_inicio' => '2012-10-09 08:40:00',
			'fecha_fin' => '2012-10-09 09:00:00',
			'consultorio_id' => '1',
			'recibido' => 0,
			'atendido' => 0,
			'cancelado' => 0
		);
		$this->records[] = array(
			'id_turno' => '4',
			'paciente_id' => null,
			'medico_id' => '1',
			'fecha_inicio' => '2012-10-09 09:00:00',
			'fecha_fin' => '2012-10-09 09:20:00',
			'consultorio_id' => '1',
			'recibido' => 0,
			'atendido' => 0,
			'cancelado' => 0
		);
		$this->records[] = array(
			'id_turno' => '5',
			'paciente_id' => null,
			'medico_id' => '1',
			'fecha_inicio' => '2012-10-09 09:20:00',
			'fecha_fin' => '2012-10-09 09:40:00',
			'consultorio_id' => '1',
			'recibido' => 0,
			'atendido' => 0,
			'cancelado' => 0
		);
		$this->records[] = array(
			'id_turno' => '6',
			'paciente_id' => null,
			'medico_id' => '1',
			'fecha_inicio' => '2012-10-09 09:40:00',
			'fecha_fin' => '2012-10-09 10:00:00',
			'consultorio_id' => '1',
			'recibido' => 0,
			'atendido' => 0,
			'cancelado' => 0
		);
		$this->records[] = array(
			'id_turno' => '7',
			'paciente_id' => null,
			'medico_id' => '1',
			'fecha_inicio' => '2012-10-09 10:00:00',
			'fecha_fin' => '2012-10-09 10:20:00',
			'consultorio_id' => '1',
			'recibido' => 0,
			'atendido' => 0,
			'cancelado' => 0
		);
		$this->records[] = array(
			'id_turno' => '8',
			'paciente_id' => null,
			'medico_id' => '1',
			'fecha_inicio' => '2012-10-09 10:20:00',
			'fecha_fin' => '2012-10-09 10:40:00',
			'consultorio_id' => '1',
			'recibido' => 0,
			'atendido' => 0,
			'cancelado' => 0
		);
		$this->records[] = array(
			'id_turno' => '9',
			'paciente_id' => null,
			'medico_id' => '1',
			'fecha_inicio' => '2012-10-09 10:40:00',
			'fecha_fin' => '2012-10-09 11:00:00',
			'consultorio_id' => '1',
			'recibido' => 0,
			'atendido' => 0,
			'cancelado' => 0
		);
		$this->records[] = array(
			'id_turno' => '10',
			'paciente_id' => null,
			'medico_id' => '1',
			'fecha_inicio' => '2012-10-09 11:00:00',
			'fecha_fin' => '2012-10-09 11:20:00',
			'consultorio_id' => '1',
			'recibido' => 0,
			'atendido' => 0,
			'cancelado' => 1
		);
		$this->records[] = array(
			'id_turno' => '11',
			'paciente_id' => null,
			'medico_id' => '1',
			'fecha_inicio' => '2012-10-09 11:20:00',
			'fecha_fin' => '2012-10-09 11:40:00',
			'consultorio_id' => '1',
			'recibido' => 0,
			'atendido' => 0,
			'cancelado' => 0
		);
        $this->records[] = array(
            'id_turno' => 12,
            'paciente_id' => 1,
            'medico_id' => 1,
            'fecha_inicio' => '2012-10-09 11:40:00',
            'fecha_fin' => '2012-10-09 11:50:00',
            'consultorio_id' => 1,
            'recibido' => 0,
            'atendido' => 0,
            'cancelado' => 0
        );
        $this->records[] = array(
            'id_turno' => 13,
            'paciente_id' => 2,
            'medico_id' => 1,
            'fecha_inicio' => '2012-10-09 12:00:00',
            'fecha_fin' => '2012-10-09 12:10:00',
            'consultorio_id' => 1,
            'recibido' => 0,
            'atendido' => 0,
            'cancelado' => 0
        );
        // Turno para busqueda de turnos disponibles de traslado
        $this->records[] = array(
            'id_turno' => 14,
            'paciente_id' => null,
            'medico_id' => 1,
            'fecha_inicio' => '2012-10-09 12:30:00',
            'fecha_fin' => '2012-10-09 12:40:00',
            'consultorio_id' => 1,
            'recibido' => 0,
            'atendido' => 0,
            'cancelado' => 0
        );
        parent::init();
    }

}
