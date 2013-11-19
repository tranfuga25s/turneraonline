<?php 
class AppSchema extends CakeSchema {

	public function before($event = array()) {
		return true;
	}

	public function after( $event = array() ) {
	    $db->cacheSources = false;
        if (isset($event['create'])) {
            switch ($event['create']) {
                case "users": {
                    App::uses('ClassRegistry', 'Utility');
                    $user = ClassRegistry::init('User');
                    $user->saveMany(array(
                        array('User' =>
                            array('id_usuario' => 1,
                                  'email' => 'paciente@turnera.com',
                                  'nombre' => 'Paciente',
                                  'apellido' => 'Paciente',
                                  'telefono' => '',
                                  'celular' => '',
                                  'obra_social_id' => 0,
                                  'notificaciones' => true,
                                  'contra' => 'paciente',
                                  'grupo_id' => 4,
                                  'facebook_id' => null,
                                  'sexo' => 'm',
                             )
                        ),
                        array('User' =>
                            array('id_usuario' => 2,
                                  'email' => 'secretaria@turnera.com',
                                  'nombre' => 'Secretaria',
                                  'apellido' => 'Secretaria',
                                  'telefono' => '',
                                  'celular' => '',
                                  'obra_social_id' => 0,
                                  'notificaciones' => true,
                                  'contra' => 'secretaria',
                                  'grupo_id' => 3,
                                  'facebook_id' => null,
                                  'sexo' => 'f',
                             )
                        ),
                        array('User' =>
                            array('id_usuario' => 3,
                                  'email' => 'medico@turnera.com',
                                  'nombre' => 'Medico',
                                  'apellido' => 'Medico',
                                  'telefono' => '',
                                  'celular' => '',
                                  'obra_social_id' => 0,
                                  'notificaciones' => true,
                                  'contra' => 'medico',
                                  'grupo_id' => 2,
                                  'facebook_id' => null,
                                  'sexo' => 'm',
                             )
                        ),
                        array('User' =>
                            array('id_usuario' => 4,
                                  'email' => 'admin@turnera.com',
                                  'nombre' => 'Administrador',
                                  'apellido' => 'Administrador',
                                  'telefono' => '',
                                  'celular' => '',
                                  'obra_social_id' => 0,
                                  'notificaciones' => true,
                                  'contra' => 'admin',
                                  'grupo_id' => 1,
                                  'facebook_id' => null,
                                  'sexo' => 'm',
                             )
                        )
                      )
                   );
                   break;
                }
                case "clinicas": {
                    App::uses('ClassRegistry', 'Utility');
                    $user = ClassRegistry::init('Clinica');
                    $user->saveMany(array(
                        array('Clinica' =>
                            array( 'id_clinica' => 1,
                                   'nombre' => 'Clinica de prueba',
                                   'direccion' => 'Dirección de prueba',
                                   'telefono' => 034526763,
                                   'email' => 'clinicaprueba@turnossantafe.com.ar',
                                   'logo' => 'logo.png'
                             )
                        )
                    ) );
                    break;
                }
                case "secretaria": {
                    App::uses('ClassRegistry', 'Utility');
                    $user = ClassRegistry::init('Secretaria');
                    $user->saveMany(array(
                        array('Secretaria' =>
                            array( 'id_secretaria' => 1,
                                   'usuario_id' => 2,
                                   'clinica_id' => 1,
                                   'resumen' => true
                             )
                        )
                    ) );
                    break;
                }
                case "medicos": {
                    App::uses('ClassRegistry', 'Utility');
                    $user = ClassRegistry::init('Medico');
                    $user->saveMany(array(
                        array('Medico' =>
                            array( 'id_medico' => 1,
                                   'usuario_id' => 3,
                                   'especialidad_id' => 1,
                                   'clinica_id' => 1,
                                   'visible' => true
                             )
                        )
                    ) );
                    break;
                }
                case "especialidades": {
                    App::uses('ClassRegistry', 'Utility');
                    $user = ClassRegistry::init('Especialidad');
                    $user->saveMany(array(
                        array('Especialidad' =>
                            array( 'id_especialidad' => 1,
                                   'nombre' => 'Ginecología'
                             )
                        )
                    ) );
                    break;
                }
                case "grupos": {
                    App::uses('ClassRegistry', 'Utility');
                    $user = ClassRegistry::init('Grupo');
                    $user->saveMany(array(
                        array('Grupo' =>
                            array( 'id_grupo' => 1,
                                   'nombre' => 'Administradores'
                             )
                        ),
                        array('Grupo' =>
                            array( 'id_grupo' => 2,
                                   'nombre' => 'Medicos'
                             )
                        ),
                        array('Grupo' =>
                            array( 'id_grupo' => 3,
                                   'nombre' => 'Secretarias'
                             )
                        ),
                        array('Grupo' =>
                            array( 'id_grupo' => 4,
                                   'nombre' => 'Pacientes'
                             )
                        )                        
                    ) );
                    break;
                }                          
            }
        }

	}

	public $avisos = array(
		'id_aviso' => array( 'type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'fecha_envio' => array( 'type' => 'datetime', 'null' => false, 'default' => null),
		'template' => array( 'type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'layout' => array( 'type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'formato' => array( 'type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'metodo' => array( 'type' => 'string', 'null' => false, 'default' => 'email', 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'to' => array( 'type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'from' => array( 'type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'subject' => array( 'type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id_aviso', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish_ci', 'engine' => 'InnoDB')
	);
	public $clinicas = array(
		'id_clinica' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'nombre' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'direccion' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'telefono' => array('type' => 'integer', 'null' => false, 'default' => null),
		'email' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'logo' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id_clinica', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish_ci', 'engine' => 'InnoDB')
	);
	public $consultorios = array(
		'id_consultorio' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'clinica_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'nombre' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id_consultorio', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish_ci', 'engine' => 'InnoDB')
	);
	public $dia_disponibilidad = array(
		'disponibilidad_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'dia' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
		'habilitado' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'hora_inicio' => array('type' => 'time', 'null' => false, 'default' => null),
		'hora_fin' => array('type' => 'time', 'null' => false, 'default' => null),
		'hora_inicio_tarde' => array('type' => 'time', 'null' => true, 'default' => null),
		'hora_fin_tarde' => array('type' => 'time', 'null' => true, 'default' => null),
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
			'disponibilidad_id' => array('column' => array('disponibilidad_id', 'dia'), 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish_ci', 'engine' => 'InnoDB')
	);
	public $disponibilidad = array(
		'id_disponibilidad' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'medico_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'duracion' => array('type' => 'integer', 'null' => false, 'default' => '10', 'length' => 20),
		'consultorio_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id_disponibilidad', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish_ci', 'engine' => 'InnoDB')
	);
	public $especialidades = array(
		'id_especialidad' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'nombre' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id_especialidad', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish_ci', 'engine' => 'InnoDB')
	);
	public $excepciones = array(
		'id_excepcion' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'medico_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'inicio' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'fin' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'rep_semanal' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'rep_mensual' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'rep_anual' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'relativo' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id_excepcion', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish_ci', 'engine' => 'InnoDB')
	);
	public $grupos = array(
		'id_grupo' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'nombre' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish2_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id_grupo', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish2_ci', 'engine' => 'InnoDB')
	);
	public $medicos = array(
		'id_medico' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'usuario_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'especialidad_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'clinica_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'visible' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id_medico', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish_ci', 'engine' => 'InnoDB')
	);
	public $obras_sociales = array(
		'id_obra_social' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'nombre' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'direccion' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'telefono' => array('type' => 'integer', 'null' => true, 'default' => null),
		'imagen' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id_obra_social', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish_ci', 'engine' => 'InnoDB')
	);
	public $secretarias = array(
		'id_secretaria' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'usuario_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'clinica_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'resumen' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id_secretaria', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish_ci', 'engine' => 'InnoDB')
	);
	public $turnos = array(
		'id_turno' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'paciente_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'medico_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'fecha_inicio' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'fecha_fin' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'consultorio_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'recibido' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'atendido' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'cancelado' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id_turno', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish_ci', 'engine' => 'InnoDB')
	);
	public $usuarios = array(
		'id_usuario' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'primary'),
		'email' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'nombre' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'apellido' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'telefono' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'celular' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'obra_social_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 20),
		'notificaciones' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'contra' => array('type' => 'text', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'grupo_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'facebook_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'sexo' => array( 'type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8' ),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id_usuario', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish_ci', 'engine' => 'InnoDB')
	);
	public $variables_avisos = array(
		'id_variable' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'modelo' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20),
		'nombre' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_spanish_ci', 'charset' => 'utf8'),
		'aviso_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 20, 'key' => 'index'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id_variable', 'unique' => 1),
			'aviso_fk' => array('column' => 'aviso_id', 'unique' => 0)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_spanish_ci', 'engine' => 'InnoDB')
	);
}
