<?php

App::uses( 'AuthComponent', 'Controller/Component' );

class InstalacionShell extends AppShell {

	public $uses = array( 'Usuario',
	                      'Clinica',
	                      'Consultorio',
	                      'Medico',
	                      'Secretaria',
	                      'Especialidad',
	                      'Disponibilidad',
	                      'DiaDisponibilidad',
	                      'Turno' );

    private $clinica =  array(
        'Clinica' => array(
                'id_clinica' => 1,
                'nombre' => 'Clinica de Prueba',
                'direccion' => 'Dirección de prueba',
                'telefono' => '2147483647',
                'email' => 'clinica.prueba@gmail.com',
                'logo' => '',
                'lat' => '-31.63381943104241',
                'lng' => '-60.69901466369629',
                'zoom' => '15'
        )
    );

    private $consultorios = array(
        0 => array(
            'Consultorio' => array(
                'id_consultorio' => 1,
                'clinica_id' => 1,
                'nombre' => 'Consultorio 1'
             )
        ),
        1 => array(
            'Consultorio' => array(
                'id_consultorio' => 2,
                'clinica_id' => 1,
                'nombre' => 'Consultorio 2'
             )
        )
    );

    private $medicos = array(
        0 => array(
            'Medico' => array(
                'id_medico' => 1,
                'usuario_id' => 17,
                'especialidad_id' => 1,
                'clinica_id' => 1,
                'visible' => true
            )
        ),
        1 => array(
            'Medico' => array(
                'id_medico' => 2,
                'usuario_id' => 6,
                'especialidad_id' => 2,
                'clinica_id' => 1,
                'visible' => true
           )
        )
    );

    private $secretarias = array(
        0 => array(
            'Secretaria' => array(
                'id_secretaria' => 2,
                'usuario_id' => 7,
                'clinica_id' => 1,
                'resumen' => true
            )
        ),
        1 => array(
            'Secretaria' => array(
                'id_secretaria' => 7,
                'usuario_id' => 18,
                'clinica_id' => 1,
                'resumen' => true
            )
        )
    );

    private $usuarios = array(
        0 => array(
        'Usuario' => array(
                'id_usuario' => 2,
                'email' => 'tranfuga25s@gmail.com',
                'nombre' => 'Esteban Javier',
                'apellido' => 'Zeller',
                'telefono' => '2313',
                'celular' => '3424293436',
                'obra_social_id' => 6,
                'notificaciones' => true,
                'contra' => 'admin',
                'grupo_id' => 1,
                'facebook_id' => '0',
                'sexo' => 'm'
        ) ),
        1 => array (
        'Usuario' => array(
                'id_usuario' => 5,
                'email' => 'admin@admin.com.ar',
                'nombre' => 'Administrador',
                'apellido' => 'Test',
                'telefono' => '0293',
                'celular' => '0349',
                'obra_social_id' => 5,
                'notificaciones' => true,
                'contra' => 'admin',
                'grupo_id' => 1,
                'facebook_id' => '0',
                'sexo' => 'm'
        ) ),
        2 => array(
        'Usuario' => array(
                'id_usuario' => 17,
                'email' => 'medico@turnera.com',
                'nombre' => 'Medico',
                'apellido' => 'Medico',
                'telefono' => '',
                'celular' => '',
                'obra_social_id' => 5,
                'notificaciones' => true,
                'contra' => 'medico',
                'grupo_id' => 2,
                'facebook_id' => '0',
                'sexo' => 'm'
        ) ),
        3 => array(
        'Usuario' => array(
                'id_usuario' => 18,
                'email' => 'secretaria@turnera.com',
                'nombre' => 'Secretaria',
                'apellido' => 'Secretaria',
                'telefono' => '',
                'celular' => '',
                'obra_social_id' => 5,
                'notificaciones' => true,
                'contra' => 'secretaria',
                'grupo_id' => 3,
                'facebook_id' => '0',
                'sexo' => 'f'
        ) ),
        4 => array(
        'Usuario' => array(
                'id_usuario' => 19,
                'email' => 'paciente@turnera.com',
                'nombre' => 'Paciente',
                'apellido' => 'Paciente',
                'telefono' => '',
                'celular' => '',
                'obra_social_id' => 5,
                'notificaciones' => true,
                'contra' => 'paciente',
                'grupo_id' => 4,
                'facebook_id' => '0',
                'sexo' => 'f'
        ) )
    );

    private $especialidades = array(
        0 => array(
        'Especialidad' => array(
            'id_especialidad' => 1,
            'nombre' => 'Ginecología'
        ) ),
        1 => array(
        'Especialidad' => array(
            'id_especialidad' => 2,
            'nombre' => 'Otorrinolaringologia'
        ) )
    );

    private $disponibilidades = array(
        0 => array(
            'Disponibilidad' => array(
                'id_disponibilidad' => 1,
                'medico_id' => 1,
                'consultorio_id' => 1,
                'duracion' => 20,
            ),
            'DiaDisponibilidad' => array(
                    array(
                        'id' => 1,
                        'disponibilidad_id' => 1,
                        'dia' => 1,
                        'habilitado' => 1,
                        'hora_inicio' => '08:00:00',
                        'hora_fin' => '11:00:00',
                        'hora_inicio_tarde' => '14:00:00',
                        'hora_fin_tarde' => '20:00:00'
                    ),
                    array(
                        'id' => 2,
                        'disponibilidad_id' => 1,
                        'dia' => 2,
                        'habilitado' => 1,
                        'hora_inicio' => '08:00:00',
                        'hora_fin' => '11:00:00',
                        'hora_inicio_tarde' => '14:00:00',
                        'hora_fin_tarde' => '20:00:00'
                    ),
                    array(
                        'id' => 3,
                        'disponibilidad_id' => 1,
                        'dia' => 4,
                        'habilitado' => 1,
                        'hora_inicio' => '08:00:00',
                        'hora_fin' => '11:00:00',
                        'hora_inicio_tarde' => '14:00:00',
                        'hora_fin_tarde' => '20:00:00'
                    ),
            )
       ),
       1 => array(
           'Disponibilidad' => array(
                'id_disponibilidad' => 2,
                'medico_id' => 2,
                'consultorio_id' => 2,
                'duracion' => 30
           ),
           'DiaDisponibilidad' => array(
                    array(
                        'id' => 4,
                        'disponibilidad_id' => 2,
                        'dia' => 1,
                        'habilitado' => 1,
                        'hora_inicio' => '08:00:00',
                        'hora_fin' => '11:00:00',
                        'hora_inicio_tarde' => '14:00:00',
                        'hora_fin_tarde' => '20:00:00'
                    ),
                    array(
                        'id' => 5,
                        'disponibilidad_id' => 2,
                        'dia' => 2,
                        'habilitado' => 1,
                        'hora_inicio' => '08:00:00',
                        'hora_fin' => '11:00:00',
                        'hora_inicio_tarde' => '14:00:00',
                        'hora_fin_tarde' => '20:00:00'
                    ),
                    array(
                        'id' => 6,
                        'disponibilidad_id' => 2,
                        'dia' => 4,
                        'habilitado' => 1,
                        'hora_inicio' => '08:00:00',
                        'hora_fin' => '11:00:00',
                        'hora_inicio_tarde' => '14:00:00',
                        'hora_fin_tarde' => '20:00:00'
                    ),
           )
       )
    );

    public function solo_datos() {

        $this->out( 'Sistema de reinistalacion de datos', 1, Shell::NORMAL  );
        // Los parametros están en $this->params
        $dataSource = $this->Clinica->getDataSource();
        $dataSource->begin();
        // Configuro la nueva clinica
        $this->out( '<info>Reiniciando Clinica</info>', 1, Shell::NORMAL  );
        if( $this->Clinica->deleteAll( array( '1=1' ), false, false ) ) {
            $this->out( '<info>Clinicas eliminadas</info>', 1, Shell::NORMAL  );
        } else {
            $this->out( '<error>No se pudo eliminar las clinicas anteriores</error>', 1, Shell::QUIET );
            $dataSource->rollback();
            return false;
        }
        if( $this->Clinica->saveMany( $this->clinica, array( 'validate' => false )  ) ) {
            $this->out( '<info>Clinicas Guardadas</info>', 1, Shell::NORMAL  );
       } else {
            $this->out( '<error>No se pudo guardar la clinica</error>', 1, Shell::QUIET );
            $dataSource->rollback();
            return false;
        }
        //////////////////////////////////////////////////////////////////////////////////////
        // Configuro el nuevo consultorio
        $this->out( '<info>Reiniciando Consultorio</info>', 1, Shell::NORMAL  );
        if( $this->Consultorio->deleteAll( array( '1=1' ), false, false ) ) {
            $this->out( '<info>Consultorios eliminadas</info>', 1, Shell::NORMAL  );
        } else {
            $this->out( '<error>No se pudo eliminar los consultorios anteriores</error>', 1, Shell::QUIET );
            $dataSource->rollback();
            return false;
        }
        if( $this->Consultorio->saveMany( $this->consultorios, array( 'validate' => false )  ) ) {
            $this->out( '<info>Consultorios Guardados</info>', 1, Shell::NORMAL  );
        } else {
            $this->out( '<error>No se pudo guardar los consultorios</error>', 1, Shell::QUIET );
            $dataSource->rollback();
            return false;
        }
        //////////////////////////////////////////////////////////////////////////////////////
        // Configuro la especialidades
        $this->out( '<info>Reiniciando Especialidades</info>', 1, Shell::NORMAL  );
        if( $this->Especialidad->deleteAll( array( '1=1' ), false, false ) ) {
            $this->out( '<info>Especialidades eliminadas</info>', 1, Shell::NORMAL  );
        } else {
            $this->out( '<error>No se pudo eliminar las especialidades anteriores</error>', 1, Shell::QUIET );
            $dataSource->rollback();
            return false;
        }
        if( $this->Especialidad->saveMany( $this->especialidades, array( 'validate' => false )  ) ) {
            $this->out( '<info>Especialidades Guardados</info>', 1, Shell::NORMAL  );
        } else {
            $this->out( '<error>No se pudo guardar las especialidades</error>', 1, Shell::QUIET );
            $dataSource->rollback();
            return false;
        }
        ////////////////////////////////////////////////////////////////////////////////////////
        // Configuro los usuarios
        // configuro el paciente
        // Configuro el admin
        $this->out( '<info>Reiniciando usuarios</info>', 1, Shell::NORMAL  );
        if( $this->Usuario->deleteAll( array( '1=1' ), false, false ) ) {
            $this->out( '<info>Usuarios eliminadas</info>', 1, Shell::NORMAL  );
        } else {
            $this->out( '<error>No se pudo eliminar los usuarios anteriores</error>', 1, Shell::QUIET );
            $dataSource->rollback();
            return false;
        }
        if( $this->Usuario->saveMany( $this->usuarios, array( 'validate' => false )  ) ) {
            $this->out( '<info>Usuarios Guardados</info>', 1, Shell::NORMAL  );
        } else {
            $this->out( '<error>No se pudo guardar los usuarios</error>', 1, Shell::QUIET );
            $dataSource->rollback();
            return false;
        }
        ////////////////////////////////////////////////////////////////////////////////////////
        // Configuro los medicos
        $this->out( '<info>Reiniciando medicos</info>', 1, Shell::NORMAL  );
        if( $this->Medico->deleteAll( array( '1=1' ), false, false ) ) {
            $this->out( '<info>Medicos eliminadas</info>', 1, Shell::NORMAL  );
        } else {
            $this->out( '<error>No se pudo eliminar los medicos anteriores</error>', 1, Shell::QUIET );
            $dataSource->rollback();
            return false;
        }
        if( $this->Medico->saveMany( $this->medicos, array( 'validate' => false ) ) ) {
            $this->out( '<info>Medicos Guardados</info>', 1, Shell::NORMAL  );
        } else {
            $this->out( '<error>No se pudo guardar los medicos</error>', 1, Shell::QUIET );
            $dataSource->rollback();
            return false;
        }
        //////////////////////////////////////////////////////////////////////////////////////////
        // configuro las secretarias
        $this->out( '<info>Reiniciando secretarias</info>', 1, Shell::NORMAL  );
        if( $this->Secretaria->deleteAll( array( '1=1' ), false, false ) ) {
            $this->out( '<info>Secretarias eliminadas</info>', 1, Shell::NORMAL  );
        } else {
            $this->out( '<error>No se pudo eliminar las Secretarias anteriores</error>', 1, Shell::QUIET );
            $dataSource->rollback();
            return false;
        }
        if( $this->Secretaria->saveMany( $this->secretarias, array( 'validate' => false )  ) ) {
            $this->out( '<info>Secretarias Guardados</info>', 1, Shell::NORMAL );
        } else {
            $this->out( '<error>No se pudo guardar los Secretarias</error>', 1, Shell::QUIET );
            $dataSource->rollback();
            return false;
        }
        //////////////////////////////////////////////////////////////////////////////////////////
        // configuro la disponibilidad
        $this->out( '<info>Reiniciando disponibilidades</info>', 1, Shell::NORMAL  );
        if( $this->Disponibilidad->deleteAll( array( '1=1' ), true, false ) ) {
            $this->out( '<info>Disponibilidades eliminadas</info>', 1, Shell::NORMAL  );
        } else {
            $this->out( '<error>No se pudo eliminar las disponibilidades anteriores</error>', 1, Shell::QUIET );
            $dataSource->rollback();
            return false;
        }
        if( $this->DiaDisponibilidad->deleteAll( array( '1=1' ), true, false ) ) {
            $this->out( '<info>Dia de Disponibilidades eliminadas</info>', 1, Shell::NORMAL  );
        } else {
            $this->out( '<error>No se pudo eliminar los dias de disponibilidad anteriores</error>', 1, Shell::QUIET );
            $dataSource->rollback();
            return false;
        }
        if( $this->Disponibilidad->saveAssociated( $this->disponibilidades[0], array( 'validate' => false ) ) &&
            $this->Disponibilidad->saveAssociated( $this->disponibilidades[1], array( 'validate' => false ) ) ) {
            $this->out( '<info>Disponibilidades Guardados</info>', 1, Shell::NORMAL );
        } else {
            $this->out( '<error>No se pudo guardar las disponibilidades</error>', 1, Shell::QUIET );
            $dataSource->rollback();
            return false;
        }
        $this->out( 'Cerrando transaccion' );
        if( $dataSource->commit() ) {
            $this->out( '<info>Commit correcto</info>', 1, Shell::QUIET );
        }
        // Regenero los turnos
        $this->out( '<info>Reiniciando turnos</info>', 1, Shell::NORMAL  );
        if( $this->Turno->deleteAll( array( '1=1' ), false, false ) ) {
            $this->out( '<info>Turnos eliminados</info>', 1, Shell::NORMAL  );
        } else {
            $this->out( '<error>No se pudo eliminar los turnos anteriores</error>', 1, Shell::QUIET );
            $dataSource->rollback();
            return false;
        }
        $this->dispatchShell( 'turnos generarTurnos' );
        return true;
    }

    public function getOptionParserReinstalar() {
        $parser = parent::getOptionParser();
        $parser->description( 'Reinstala los datos de ejemplo en la configuracion actual' );
        $parser->epilog( 'TR Sistemas Informaticos Integrales' );
        $parser->addOption( 'eliminar_turnos', array(
            'help' => 'Elimina los turnos anteriores',
            'short' => 't',
            'boolean' => true
        ));
        $parser->addOption( 'elimina_usuarios', array(
            'help' => 'Elimina todos los usuarios que se hayan registrado',
            'short' => 'u',
            'boolean' => true
        ));
        return $parser;
    }

    public function getOptionParser() {
        $parser = parent::getOptionParser();
        // Configuro las opciones
        $parser->description( array( 'Asistente de instalación de datos de muestra para página de demostracion' ) );
        $parser->epilog( 'TR Sistemas Informaticos Integrales' );
        $parser->addOption( 'database', array(
            'short' => 'd',
            'help' => 'Instalar datos en la conexion de datos asignada',
            'default' => 'default',
            'required' => false
            )
        );
        $parser->addOption( 'tipo_cliente', array(
            'short' => 't',
            'help' => 'Tipo de cliente para copiar los datos',
            'default' => 'bs',
            'required' => true,
            'choices' => array( 'bs', 'ms', 'ts', 'bd', 'mb', 'td' )
        ) );
        $parser->addOption( 'id_cliente', array(
            'short' => 'c',
            'help' => 'Identificador del cliente',
            'required' => true
        ) );
        $parser->addOption( 'datos_ejemplo', array(
            'short' => 'x',
            'help' => 'Instalar datos de ejemplo',
            'required' => true,
            'boolean' => true
        ) );
        $parser->addOption( 'nombre_cliente', array(
            'short' => 'n',
            'help' => 'Nombre del cliente ( usado para configurar la carpeta )',
            'required' => true
        ));
        $parser->addSubcommand( 'solo_datos', array(
            'help' => 'Reinstala los datos de ejemplo',
            'parser' => $this->getOptionParserReinstalar()
        ) );
        return $parser;
    }
}
?>