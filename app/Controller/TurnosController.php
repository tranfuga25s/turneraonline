<?php
App::uses('AppController', 'Controller');
App::uses('CakeTime', 'Utility');
/**
 * Turnos Controller
 *
 * @property Turno $Turno
 */
class TurnosController extends AppController {

	var $helpers = array( 'Html', 'Form', 'Paginator', 'Js' => array( 'Jquery' ), 'Calendar2' );
	var $uses = array( 'Turno', 'Especialidad', 'Avisos', 'Clinica' );
	var $components = array( 'RequestHandler' );

	public function beforeFilter() {
		$this->Auth->allow( 'calcularTurnos' );
		AppController::beforeFilter();
	}

	public function isAuthorized( $usuario = null ) {
		switch( $usuario['grupo_id'] ) {
			case 1: // Administradores
			{
				return true;
				break;
			}
			case 2: // Medicos
			case 3: // Secretarias
			{
			    switch( $this->request->params['action'] ) {
                    case 'recibido':
                    case 'atendido':
                    case 'sobreturno':
                    case 'cancelar':
                    case 'reservarTurno':
                    {
                        return true; break;
                    }
			    }
                break;
			}
			case 4: // Usuario normal
			{
				switch( $this->request->params['action'] ) {
					case 'verTurnos':
					case 'ver':
					case 'cargarDatos':
					case 'cargarCalendario':
					case 'cargarTurnos':
					case 'nuevo':
					case 'cambiarHorasAviso':
					case 'cancelar':
					{ return true; break; }
					default:
					{ return false; break; }
				}
				break;
			}
		}
		return false;
	}

	/**
	* Muestra los turnos del usuario
	*/
	public function verTurnos( $id_usuario = null ) {
		if( $id_usuario == null ) {
			// Supongo que está con el usuario actual
			$id_usuario = $this->Auth->user( 'id_usuario' );
		}
		$this->Turno->Medico->unbindModel( array( 'hasMany' => array( 'Turno' ), 'belongsTo' => array( 'Clinica', 'Especialidad' ), 'hasOne' => array( 'Disponibilidad' ) ) );
		$this->Turno->Consultorio->unbindModel( array( 'belongsTo' => array( 'Clinica' ) ) );
		$this->Turno->Paciente->virtualFields = array( 'razonsocial' => 'CONCAT( Paciente.apellido, \', \', Paciente.nombre )' );
		$this->set( 'turnos', $this->Turno->turnosReservados( $id_usuario ) );
		$this->set( 'turnosanteriores', $this->Turno->turnosAnteriores( $id_usuario ) );
	}

	/**
	* view method
	*
	* @param string $id
	* @return void
	*/
	public function ver($id = null) {
		$this->Turno->id = $id;
		if (!$this->Turno->exists()) {
			throw new NotFoundException(__('Invalid turno'));
		}
		$this->set('turno', $this->Turno->read(null, $id));
	}

	/**
	* Solicita un nuevo turno con el usuario loggeado
	*
	* @return void
	*/
	public function nuevo( $id_usuario = null ) {
		$this->set( 'usuario', $this->Auth->user() );
	}

	/**
	* Solicita los datos segun los parametros pasados desde ajax
	*
	* @return json array con los elementos html.
	*/
	public function cargarDatos() {
		if( $this->request->is('post') ) {
			if( !isset( $this->request->data['Turno']['paso']  ) ) {
				debug( $this->request->data );
				die( "Paso no seteado" );
			} else {
				$paso = $this->request->data['Turno']['paso'];
			}
			switch( $paso ) {
				case 1: // Selecciono la clinica
				{
					// Si existe una sola clinica paso al siguiente paso
					if( $this->Clinica->unaSola() ) {
						$paso++;
						$clinica = $this->Clinica->unica();
						$id_clinica = $clinica['Clinica']['id_clinica'];
						$this->set( 'id_clinica', $id_clinica );
						$this->set( 'nombre_clinica', $clinica['Clinica']['nombre'] );
					} else {
						$this->set( 'clinicas', $this->Clinica->find( 'list' ) );
						break;
					}
				}
				case 2: { // Selecciono la especialidad y/o médico
					if( !isset( $id_clinica ) ) { $id_clinica = $this->request->data['Turno']['id_clinica']; }
					$especialidades = $this->Turno->Medico->Especialidad->listaPorClinica( $id_clinica );
					$medicos = $this->Turno->Medico->listaPorClinica( $id_clinica );
					$this->set( compact( 'especialidades', 'medicos', 'id_clinica' ) );
					break;
				}
				case 3:  { // Se eligió una especialidad
					if( !isset( $id_clinica ) ) { $id_clinica = $this->request->data['Turno']['id_clinica']; }
					if( !isset( $id_especialidad ) ) { $id_especialidad = $this->request->data['Turno']['id_especialidad']; }
					$medicos = $this->Turno->Medico->listaPorClinica( $id_clinica );
					$this->set( compact( 'medicos', 'id_clinica', 'id_especialidad' ) );
					break;
				}
				case 4: { // Se eligió un medico
					if( !isset( $id_clinica ) ) { $id_clinica = $this->request->data['Turno']['id_clinica']; }
					if( !isset( $id_medico ) ) { $id_medico = $this->request->data['Turno']['id_medico']; }
                    if( !isset( $id_especialidad ) ) {
                        if( !array_key_exists( 'id_especialidad', $this->request->data['Turno'] ) ) {
                            $this->Turno->Medico->recursive = -1;
                            $this->Turno->Medico->id = $id_medico;
                            $id_especialidad = $this->Turno->Medico->field( 'especialidad_id' );
                            $this->Turno->Medico->Especialidad->recursive = -1;
                            $this->Turno->Medico->Especialidad->id = $id_especialidad;
                            $nombre_esp = $this->Turno->Medico->Especialidad->field( $this->Turno->Medico->Especialidad->displayField );
                            $this->set( 'nombre_especialidad', $nombre_esp );
                        } else {
                            $id_especialidad = $this->request->data['Turno']['id_especialidad'];
                        }
                    }
					$this->set( compact( 'id_clinica', 'id_medico', 'id_especialidad' ) );
					$paso++;
				}
				case 5: { // Muestro el calendario

					if( !isset( $id_clinica ) ) { $id_clinica = $this->request->data['Turno']['id_clinica']; }
					if( !isset( $id_medico ) ) { $id_medico = $this->request->data['Turno']['id_medico']; }
					if( !isset( $id_especialidad ) ) { $id_especialidad = $this->request->data['Turno']['id_especialidad']; }

					// De manera predeterminada el el día de hoy que hay que cargar
					$hoy = new DateTime('now');
					$dia = $hoy->format( 'd' );
					$mes = $hoy->format( 'n' );
					$ano = $hoy->format( 'Y' );

					// Verifico si no estoy pidiendo otro més o año
					if( isset( $this->request->data['Turno']['mes'] ) ) { $mes = $this->request->data['Turno']['mes']; }
					if( isset( $this->request->data['Turno']['ano'] ) ) { $ano = $this->request->data['Turno']['ano']; }

					// Busco la cantidad de meses hacia adelante y atras que se pueden buscar
					$cant_dias = Configure::read( 'Turnera.dias_turnos' );
					if( $cant_dias == null ) {
						die( "Error de lectura de configuracion" );
					}

					$fecha_inicio = new DateTime( 'now' );

					$fecha_fin = $fecha_inicio;
					$fecha_fin->add( new DateInterval( "P".$cant_dias."D" ) );

					$fecha_buscada = new DateTime();
					$fecha_buscada->setDate( $ano, $mes, 1 );
					$fecha_buscada2 = $fecha_buscada;
					$fecha_buscada2->add( new DateInterval( "P1M" ) );

					if( $fecha_buscada > $fecha_inicio && $fecha_buscada < $fecha_fin ) {
						$this->set( 'meses_anteriores', 1 );
					} else { $this->set( 'meses_anteriores', 0 ); }
					if( $fecha_fin > $fecha_buscada2 ) {
						$this->set( 'meses_siguientes', 1 );
					} else { $this->set( 'meses_siguientes', 0 ); }

					$turnos = $this->Turno->buscarDisponibilidad( $mes, $ano, $id_clinica, $id_especialidad, $id_medico, true );

					$this->set( compact( 'dia', 'mes', 'ano', 'turnos', 'id_clinica', 'id_medico', 'id_especialidad' ) );
					break;
				}
				case 6: { // Muestro los horarios
				    // Verifico que lleguen todos los parametros necesarios
				    $datos = $this->request->data['Turno'];
				    if( !array_key_exists( 'dia', $datos ) ) {
                        throw new NotFoundException( 'Falta indicar el día que se desea el turno' );
				    }
                    if( !array_key_exists( 'mes', $datos ) ) {
                        throw new NotFoundException( 'Falta indicar el mes que se desea el turno' );
                    }
                    if( !array_key_exists( 'ano', $datos ) ) {
                        throw new NotFoundException( 'Falta indicar el año que se desea el turno' );
                    }
                    if( !array_key_exists( 'id_medico', $datos ) ) {
                        throw new NotFoundException( 'Falta indicar el medico que se desea el turno' );
                    }

                    // Veo si el día es hoy de poner los turnos con hora mayor a la actual
                    if( $datos['dia'] == date( 'j' ) &&
                        $datos['mes'] == date( 'n' ) &&
                        $datos['ano'] == date( 'Y' ) ) {
                        $this->set( 'turnos', $this->Turno->buscarTurnos( $datos['dia'],
                                                                          $datos['mes'],
                                                                          $datos['ano'],
                                                                          $datos['id_clinica'],
                                                                          $datos['id_especialidad'],
                                                                          $datos['id_medico'],
                                                                          false,
                                                                          date( 'H' ),
                                                                          date( 'i' ) ) );
                    } else {
                        $this->set( 'turnos', $this->Turno->buscarTurnos( $datos['dia'],
                                                                          $datos['mes'],
                                                                          $datos['ano'],
                                                                          $datos['id_clinica'],
                                                                          $datos['id_especialidad'],
                                                                          $datos['id_medico'] ) );
                    }
                    $this->set( 'nombre_fecha', implode( '/', array( $datos['dia'], $datos['mes'], $datos['ano'] ) ) );
					break;
				}
                case 7: // Confirmación de reserva del turno
                {
                    if( $this->request->data['Turno']['id_paciente'] == null ) {
                        $id_paciente = $this->Auth->user( 'id_usuario' );
                    } else {
                        $id_paciente = $this->request->data['Turno']['id_paciente'];
                    }

                    $this->Turno->id = $this->request->data['Turno']['id_turno'];
                    if (!$this->Turno->exists()) {
                        throw new NotFoundException( 'El turno solicitado no existe' );
                    }
                    $this->Turno->unbindModel( array( 'belongsTo' => array( 'Paciente' ) ) );
                    $turno = $this->Turno->read();

                    // Verificar restricción de cantidad de turnos x día.
                    if( $this->Turno->verificarTurnosEnDia( $turno['Turno']['fecha_inicio'], $id_paciente ) ) {
                        $this->Session->setFlash( "Usted ya ha reservado un turno para este día. Solo puede reservar un turno por día" );
                        $this->render( 'nuevo/error' );
                        return;
                    }

                    $tiempo = Configure::read( 'Turnera.notificaciones.horas_proximo' );

                    $this->loadModel( 'Usuario' );
                    $this->Usuario->id = $id_paciente;
                    if( !$this->Usuario->exists() ) {
                        throw new NotFoundException( 'El usuario solicitado no existe' );
                    }
                    $this->Usuario->recursive = -1;
                    $usuario = $this->Usuario->read();

                    $turno['Medico'] = $this->Usuario->read( null, $turno['Medico']['usuario_id'] );

                    $error = '';
                    if( $this->Turno->reservar( $this->request->data['Turno']['id_turno'], $id_paciente, $error )  ) {
                        $this->requestAction( array( 'controller' => 'avisos',
                                                     'action' => 'agregarAvisoNuevoTurno',
                                                     'id_turno' => $this->request->data['Turno']['id_turno'],
                                                     'id_paciente' => $id_paciente ) );
						$this->set( 'tiempo', $tiempo );
	                    $this->set( 'turno', $turno );
	                    $this->set( 'usuario', $usuario );
	                    $this->set( 'error', $error );
                    } else {
                    	$this->Session->setFlash( $error );
						$this->render( 'nuevo/error' );
						return;
                    }
                	break;
                }
			}
			$this->set( 'paso', $paso+1 );
			return $this->render( 'nuevo/paso'.$paso );
		} else {
			return json_encode( "Error!" );
		}
	}

    /**
     * \fn reservarTurno( $id_turno, $id_paciente )
     * Reserva un turno por parte del medico o la secretaria
     * La parte del usuario se hace por el tipo tutorial
     */
    public function reservarTurno( $id_paciente = null ) {

        // Los datos vienen por post -  a travez de agregar el paciente
        if( !$this->request->isPost() ) {
            $this->request->data['Turno'] = $this->Session->read(  'turno' );
            $this->Session->delete( 'turno' );
        }
        // Verifico los parámetros
        if( !array_key_exists( 'rpaciente', $this->data['Turno'] ) ) {
            throw new MissingParameterException( 'rpaciente' );
        } else {
            if( $id_paciente == null ) {
                $id_paciente = intval( array_pop( array_reverse( split( '-', $this->data['Turno']['rpaciente'] ) ) ) );
            }
        }

        if( !array_key_exists( 'id_turno', $this->data['Turno'] ) ) {
            throw new MissingParameterException( 'id_turno' );
        } else { $id_turno = $this->data['Turno']['id_turno']; }

        if( !array_key_exists( 'controlador', $this->data['Turno'] ) ) {
            throw new MissingParameterException( 'controlador' );
        } else { $controlador = $this->data['Turno']['controlador']; }

        $this->Turno->id = $id_turno;
        if (!$this->Turno->exists()) {
            throw new NotFoundException( 'El turno solicitado no existe' );
        }

        $this->loadModel( 'Usuario' );
        $this->Usuario->id = $id_paciente;
        if( !$this->Usuario->exists() ) {
            $this->Session->setFlash( 'El usuario seleccionado no existe, por favor, ingrese sus datos para darlo de alta.', 'flash/info' );
            $this->Session->write( array( 'turno' => $this->data['Turno'] ) );
            $this->redirect( array( 'controller' => 'usuarios',
                                    'action' => 'altaTurno',
                                    $id_turno,
                                    $this->Turno->field( 'medico_id' ),
                                    $this->data['Turno']['rpaciente'],
                                    'reservarTurno' ) );
        }

        $error = '';
        if( $this->Turno->reservar( $id_turno, $id_paciente, $error )  ) {
            $this->requestAction( array( 'controller' => 'avisos',
                                         'action' => 'agregarAvisoNuevoTurno',
                                         'id_turno' => $id_turno,
                                         'id_paciente' => $id_paciente ) );
            $this->Session->setFlash( "Turno reservado correctamente", 'flash/success' );
        } else {
            $this->Session->setFlash( "No se pudo hacer la reserva.<br /> Razón: ".$error, 'flash/error' );
        }

        $this->redirect( array( 'action' => 'turnos', 'controller' => $controlador ) );

    }

    /**
     * Funcion para marcar un turno como atendido
     * desde la interfaz de médico o secretaria
     */
    public function atendido( $id_turno = null, $controlador = null ) {

        $this->Turno->id = $id_turno;
        if( ! $this->Turno->exists() ) {
            throw new NotFoundException( 'El turno no existe, '.$id_turno );
        }
        $this->Turno->set( 'recibido', true );
        $this->Turno->set( 'atendido', true );
        if( $this->Turno->save() ) {
            $this->Session->setFlash( 'El turno ha sido colocado como atendido' , 'flash/success' );
        } else {
            $this->Session->setFlash( 'No se pudo colocar el turno como atendido', 'flash/error' );
        }
        $this->redirect( array( 'action' => 'turnos', 'controller' => $controlador ) );
    }

   /**
    * Marca un turno como recibido desde la vista del secretario y el médico
    */
    public function recibido( $id_turno = null, $controlador = null ) {

        $this->Turno->id = $id_turno;
        if( ! $this->Turno->exists() ) {
            throw new NotFoundException( 'El turno no existe, '.$id_turno );
        }
        $this->Turno->set( 'recibido', true );
        if( $this->Turno->save() ) {
            $this->Session->setFlash( 'El turno ha sido colocado como recibido'  , 'flash/success' );
        } else {
            $this->Session->setFlash( 'No se pudo colocar el turno como recibido', 'flash/error' );
        }

        $this->redirect( array( 'action' => 'turnos', 'controller' => $controlador ) );
    }

   /**
    * Genera un sobreturno con los datos especificados
    * Los parametros son utilizados solamente cuando se debe dar de alta el usuario que fue ingresado.
    * Se necesitan los siguientes parametros: id_turno, spaciente, id_medico, hora, min, duracion.
    * spaciente es la cadena: <id_usuario - nombre usuario> si el usuario está dado de alta sino se dará de alta.
    */
    public function sobreturno( $id_paciente = null ) {
        if( $this->request->isPost() ) {
            extract( $this->request->data['Turno'] );
            // Extraigo el ID del paciente
            if( !isset( $spaciente ) ) {
                throw new MissingParameterException( 'spaciente' );
            }
            $id_paciente = intval( array_pop( array_reverse( split( '-', $this->data['Turno']['spaciente'] ) ) ) );
        } else {
            // Si entro por aquí, tuve que dar de alta el paciente.
            extract( $this->Session->read( 'turno' ) );
            $this->Session->delete( 'turno' );
        }

        // Verifico los parámetros
        if( !isset( $id_medico ) ) {
            throw new MissingParameterException( 'id_medico' );
        }
        // Usa el turno para sacar el día
        if( !isset( $id_turno ) ) {
            throw new MissingParameterException( 'id_turno' );
        }
        if( !isset( $id_paciente ) ) {
            throw new MissingParameterException( 'id_paciente' );
        }
        if( !isset( $duracion ) ) {
            throw new MissingParameterException( 'duracion' );
        }
        if( !isset( $hora ) ) {
            throw new MissingParameterException( 'hora' );
        }
        if( !isset( $min ) ) {
            throw new MissingParameterException( 'min' );
        }
        if( !isset( $controlador ) ) {
            throw new MissingParameterException( 'controlador' );
        }

        $this->Turno->id = $id_turno;
        if( ! $this->Turno->exists() ) {
            throw new NotFoundException( 'El turno no existe, '.$id_turno );
        }
        $this->Turno->Paciente->virtualFields = '';
        $this->Turno->unbindModel( array( 'belongsTo' => array( 'Consultorio', 'Medico', 'Paciente' ) ) );
        $turno = $this->Turno->read();

        $this->Turno->Paciente->id = $id_paciente;
        if( ! $this->Turno->Paciente->exists() ) {
            $this->Session->setFlash( 'El usuario seleccionado no existe, por favor, ingrese sus datos para darlo de alta.', 'flash/info' );
            $this->Session->write( array( 'turno' => $this->data['Turno'] ) );
            $this->redirect( array( 'controller' => 'usuarios',
                                    'action' => 'altaTurno',
                                    $id_turno,
                                    $id_medico,
                                    $this->request->data['Turno']['spaciente'],
                                    'sobreturno' ) );
        }

        $this->Turno->Medico->id = $id_medico;
        if( ! $this->Turno->Medico->exists() ) {
            throw new NotFoundException( 'El médico no existe, '.$id_medico );
        }

        // Cargo la cantidad de horas configuradas en el sistema
        $tiempo = Configure::read( 'Turnera.notificaciones.horas_proximo' );
        if( $duracion == null ) {
            $duracion = $this->Turno->Medico->Disponibilidad->duracionPorMedico( $id_medico ); /// @TODO: Generar metodo en disponibilidad
        }

        // Genero el sobreturno
        $finicio = DateTime::createFromFormat( 'Y-m-d H:i:s', $turno['Turno']['fecha_inicio'] );
        $finicio->setTime( $hora, $min, 0 );
        $ffin = clone $finicio;
        $ffin->add( new DateInterval( "PT".$duracion."M" ) );
        $data = array(  'Turno' =>
                array(  'fecha_inicio'   => $finicio->format( 'Y-m-d H:i:s' ),
                        'fecha_fin'      => $ffin->format( 'Y-m-d H:i:s' ),
                        'medico_id'      => $id_medico,
                        'consultorio_id' => $turno['Turno']['consultorio_id'],
                        'paciente_id'    => $id_paciente,
                        'recibido'       => true,
                        'atendido'       => false,
                        'cancelado'      => false
                )
            );
        $this->Turno->create();
        if( $this->Turno->save( $data ) ) {
            $this->Session->setFlash( 'Sobre turno creado correctamente', 'flash/info' );
        } else {
            $this->Session->setFlash( 'No se pudo generar el sobreturno' , 'flash/error' );
            pr( $this->Turno->validationErrors );
            die('Error al hacer el save del sobreturno' );
        }
        $this->redirect( array( 'action' => 'turnos', 'controller' => $controlador ) );
    }

    public function administracion_trasladar( $id_turno = null ) {
        if( $this->request->isPost() ) {
            // Pedido por ajax
            if( $this->request->params['named']['id_turno'] == null ) {
                throw new NotFoundException( 'El turno solicitado no existe' );
            }
            $this->autoRender = false;
            $id_turno = $this->request->params['named']['id_turno'];
            return json_encode( array( 'estado' => false, 'id_turno' => $id_turno, 'mensaje' => 'No implementado todavía' ) );
        }
    }

    /*!
     * Funcion llamada cuando un usuario desea cancelar un turno que resevó con anterioridad.
     */
    public function cancelar( $id_turno = null ) {

        if( $this->request->isPost() && $id_turno == null ) {
            extract( $this->request->data['Turno'] );
            if( !isset( $id_turno ) ) {
                throw new MissingParameterException( "id_turno" );
            }
        } else {
             if( $id_turno == null ) {
                throw new NotFoundException( "El turno no está especificado" );
             }
             $quien = 'p'; // Libera el turno
        }

        $this->Turno->id = $id_turno;
        if( !$this->Turno->exists() ) {
            throw new NotFoundException( "El turno especificado no existe" );
        }

        if( $quien == 'p' ) {
            // Libero el turno.
            if( $this->Turno->liberar( $id_turno ) ) {
                // Veo el aviso
                $this->requestAction( array( 'controller' => 'avisos', 'action' => 'cancelarAvisoNuevoTurno', $id_turno ) );
                $this->Session->setFlash( "Turno cancelado correctamente.", 'flash/success' );
            } else {
                $this->Session->setFlash( "Existió un error al intentar cancelar el turno", 'flash/error' );
            }
        } else if( $quien == 'm' ) {
            if( $this->Turno->cancelar( $id_turno ) ) {
                // Veo el aviso
                $this->requestAction( array( 'controller' => 'avisos', 'action' => 'cancelarAvisoNuevoTurno', $id_turno ) );
                $this->Session->setFlash( "Turno cancelado correctamente.", 'flash/success' );
            } else {
                $this->Session->setFlash( "Existió un error al intentar cancelar el turno", 'flash/error' );
            }
        }

        if( isset( $controlador ) && $controlador != null ) {
            $this->redirect( array( 'controller' => $controlador, 'action' => 'turnos' ) );
        } else {
            $this->redirect( array( 'action' => 'verTurnos' ) );
        }
    }

    /*!
     * Permite modificar la cantidad de horas de anterioridad con la que se le enviará el aviso de turno proximo por email.
     */
    public function cambiarHorasAviso()
    {
        if( !$this->request->isPost() ) {
            throw new NotFoundExpection( 'Metodo no implementado de esta forma' );
            return;
        }
        $id_turno = $this->request->data['Turno']['id_turno'];
        $nhoras = $this->request->data['Turno']['horas'];
        $this->Turno->id = $id_turno;
        if( !$this->Turno->exists() ) {
            throw new NotFoundException( "El turno solititado no existe!" );
            return;
        }
        $hturno = $this->Turno->field( 'fecha_inicio' );
        $this->loadModel( "Aviso" );
        if( $this->Aviso->cambiarHorasTurno( $id_turno, $nhoras, $hturno ) ) {
            $this->Session->setFlash( 'Cantidad de horas cambiadas correctamente', 'flash/success' );
        } else {
            $this->Session->setFlash( 'No se pudieron cambiar la cantidad de horas. Se dejó de manera predeterminada.', 'flash/error' );
        }
        $this->redirect( array( 'action' => 'verTurnos' ) );
    }

    /*!
     * administracion_index method
     *
     * @return void
     */
    public function administracion_index() {
        $conditions = array();
        if( !empty( $this->request->data ) ) {
            if( $this->request->data['Turno']['atendido']  ) { $conditions['atendido'] = true;   }
            if( $this->request->data['Turno']['reservado'] ) { $conditions[] = '`Turno`.`paciente_id` IS NOT NULL';  }
            if( $this->request->data['Turno']['cancelado'] ) { $conditions['cancelado'] = true;  }
            if( $this->request->data['Turno']['consultorio_id'] != 0 ) { $conditions['consultorio_id'] = $this->request->data['Turno']['consultorio_id']; }
            if( $this->request->data['Turno']['medico_id'] != 0 ) { $conditions['medico_id'] = $this->request->data['Turno']['medico_id']; }
            if( $this->request->data['Turno']['fechaDesdeCkB'] ) {
                $conditions['DATE( `Turno`.`fecha_inicio` ) >= '] = $this->request->data['Turno']['fechaDesde']['year'].'-'.
                                                                    $this->request->data['Turno']['fechaDesde']['month'].'-'.
                                                                    $this->request->data['Turno']['fechaDesde']['day']; }
            if( $this->request->data['Turno']['fechaHastaCkB'] ) {
                $conditions['DATE( `Turno`.`fecha_fin` ) <= '] = $this->request->data['Turno']['fechaHasta']['year'].'-'.
                                                                 $this->request->data['Turno']['fechaHasta']['month'].'-'.
                                                                 $this->request->data['Turno']['fechaHasta']['day']; }
        }
        $this->Turno->recursive = 2;
        $this->Turno->Medico->unbindModel( array( 'hasMany' => array( 'Turno' ) ) );
        $this->Turno->Paciente->virtualFields = array( 'razonsocial' => 'CONCAT( Paciente.apellido, \', \', Paciente.nombre )' );
        $this->set('turnos', $this->paginate( 'Turno', $conditions ) );
        $this->set( 'consultorios', $this->Turno->Consultorio->find('list') );
        $this->set( 'medicos', $this->Turno->Medico->lista2() );
    }

    /**
    * administracion_view method
    *
    * @param string $id
    * @return void
    */
    public function administracion_view($id = null) {
        $this->Turno->id = $id;
        if (!$this->Turno->exists()) {
            throw new NotFoundException(__('Invalid turno'));
        }
        $this->Turno->recursive = 2;
        $this->Turno->Medico->unbindModel( array( 'hasMany' => array( 'Turno' ) ) );
        $this->Turno->Paciente->virtualFields = array( 'razonsocial' => 'CONCAT( Paciente.apellido, \', \', Paciente.nombre )' );
        $this->set('turno', $this->Turno->read(null, $id));
    }

    /**
    * administracion_add method
    *
    * @return void
    */
    public function administracion_add() {
        if ($this->request->is('post')) {
            $this->Turno->create();
            if ($this->Turno->save($this->request->data)) {
                $this->Session->setFlash(__('The turno has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The turno could not be saved. Please, try again.'));
            }
        }
        $pacientes = $this->Turno->Paciente->find('list');
        $medicos = $this->Turno->Medico->find('list');
        $consultorios = $this->Turno->Consultorio->find('list');
        $this->set(compact('pacientes', 'medicos', 'consultorios'));
    }

    /**
    * administracion_edit method
    *
    * @param string $id
    * @return void
    */
    public function administracion_edit($id = null) {
        throw new NotFoundException( "Metodo no necesario" );
        $this->Turno->id = $id;
        if (!$this->Turno->exists()) {
            throw new NotFoundException( 'Turno Invalido' );
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Turno->save($this->request->data)) {
                $this->Session->setFlash( 'El turno ha sido guardado' );
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The turno could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Turno->read(null, $id);
        }
        $pacientes = $this->Turno->Paciente->find('list');
        $medicos = $this->Turno->Medico->find('list');
        $consultorios = $this->Turno->Consultorio->find('list');
        $this->set(compact('pacientes', 'medicos', 'consultorios'));
    }

    /**
    * Metodo para eliminar un turno desde la administración
    *
    * @param string $id Identificador del turno a eliminar.
    * @return void
    */
    public function administracion_delete( $id = null ) {
        if( !$this->request->is( 'post' ) ) {
            throw new MethodNotAllowedException();
        }
        $this->Turno->id = $id;
        if (!$this->Turno->exists()) {
            throw new NotFoundException( 'El turno no existe' );
        }
        $reservado = $this->Turno->field( 'paciente_id' );
        if( $reservado != null ) {
            $this->Session->setFlash( 'El turno está reservado. Canceleló primero.' );
            $this->redirect( array( 'action' => 'index' ) );
        }
        $recibido = $this->Turno->field( 'recibido' );
        if( $recibido == true ) {
            $this->Session->setFlash( 'El turno está marcado como recibido. Canceleló primero.' );
            $this->redirect( array( 'action' => 'index' ) );
        }
        $atendido = $this->Turno->field( 'atendido' );
        if( $atendido == true ) {
            $this->Session->setFlash( 'El turno está atendido ya. Canceleló primero.' );
            $this->redirect( array( 'action' => 'index' ) );
        }
        if ($this->Turno->delete()) {
            $this->Session->setFlash('El turno fue eliminado correctamente');
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash('El turno no pudo ser eliminado');
        $this->redirect(array('action' => 'index'));
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Codigo suceptible a eliminacion!
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function cargarCalendario() {
		if( $this->request->is( "post" ) ) {
			//pr( $this->request->data );
			if( isset( $this->request->data['mes'] ) ) { $mes = $this->request->data['mes']; }
			if( isset( $this->request->data['ano'] ) ) { $ano = $this->request->data['ano']; }
			$id_clinica = $this->request->data['id_clinica'];
			$id_especialidad = $this->request->data['id_especialidad'];
			$id_medico = $this->request->data['id_medico'];
			if( !isset( $ano ) || $ano == 0 ) { $ano = date( 'Y' ); }
			if( !isset( $mes ) || $mes == 0 ) { $mes = date( 'n' ); }

			// Busco la cantidad de meses hacia adelante y atras que se pueden buscar
			$cant_dias = Configure::read( 'Turnera.dias_turnos' );
			if( $cant_dias == null ) {
				die( "Error de lectura de configuracion" );
			}

			$fecha_inicio = new DateTime( 'now' );

			$fecha_fin = $fecha_inicio;
			$fecha_fin->add( new DateInterval( "P".$cant_dias."D" ) );

			$fecha_buscada = new DateTime();
			$fecha_buscada->setDate( $ano, $mes, 1 );
			$fecha_buscada2 = $fecha_buscada;
			$fecha_buscada2->add( new DateInterval( "P1M" ) );

			if( $fecha_buscada > $fecha_inicio && $fecha_buscada < $fecha_fin ) {
				$this->set( 'meses_anteriores', 1 );
			} else { $this->set( 'meses_anteriores', 0 ); }
			if( $fecha_fin > $fecha_buscada2 ) {
				$this->set( 'meses_siguientes', 1 );
			} else { $this->set( 'meses_siguientes', 0 ); }
			// Busco en la disponibilidad de los medicos
			$turnos = $this->Turno->buscarDisponibilidad( $mes, $ano, $id_clinica, $id_especialidad, $id_medico, true );
			$this->set( 'turnos', $turnos );
			$this->set( 'mes', $mes );
			$this->set( 'ano', $ano );
		}
	}


	public function cargarTurnos() {
		if( $this->request->is( "post" ) ) {
			$dia = $this->request->data['dia'];
			$mes = $this->request->data['mes'];
			$ano = $this->request->data['ano'];
			$id_clinica = $this->request->data['id_clinica'];
			$id_especialidad = $this->request->data['id_especialidad'];
			$id_medico = $this->request->data['id_medico'];
			// Veo si el día es hoy de poner los turnos con hora mayor a la actual
			if( $dia == date( 'j' ) && $mes == date( 'n' )  && $ano == date( 'Y' ) ) {
				$this->set( 'turnos', $this->Turno->buscarTurnos( $dia, $mes, $ano, $id_clinica, $id_especialidad, $id_medico, false, date( 'H' ), date( 'i' ) ) );
			} else {
				$this->set( 'turnos', $this->Turno->buscarTurnos( $dia, $mes, $ano, $id_clinica, $id_especialidad, $id_medico ) );
			}
			$this->set( 'medicos', $this->Turno->Medico->lista() );
			$this->set( 'fecha', $dia.'/'.$mes.'/'.$ano );
		} else {
			echo "Metodo no autorizado.";
			$this->autoRender = false;
			return;
		}
	}

   /*!
    * Muestra el listado de turnos según un médico específico
    * \param id_medico Identificador del medico
    */
    public function administracion_verPorMedico( $id_medico = null )
	{
		$this->loadModel( 'Medico' );
		$this->Medico->id = $id_medico;
		if( !$this->Medico->exists() ) {
			throw new NotFoundException( "No se puede encontrar el medico que busca" );
		}
		$this->Medico->unbindModel( array( 'hasMany' => array( 'Turnos' ) ) );
		$this->set( 'medico', $this->Medico->read( null, $id_medico ) );
		$this->Turno->Paciente->virtualFields = array( 'razonsocial' => ' CONCAT( Paciente.apellido, \', \', Paciente.nombre ) ' );
		$this->paginate = array( 'medico_id' => $id_medico );
		$this->set( 'turnos', $this->paginate() );
	}



}
