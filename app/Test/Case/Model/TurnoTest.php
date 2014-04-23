<?php
App::uses('Turno', 'Model');

/**
 * Turno Test Case
 * @property Turno Turno
 */
class TurnoTestCase extends CakeTestCase {

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = array('app.clinica',
        'app.consultorio',
        'app.medico',
        'app.turno',
        'app.usuario'
    );

    public $fecha_buena = "2012-10-09";
    public $fecha = "2000-10-09";

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();
        $this->Turno = ClassRegistry::init('Turno');
    }

    /**
     *
     */
    public function testBasico() {
        $this->assertEqual(1, 1);
    }

    /**
     * Verifica la creación de turnos al generar los turnos del día
     */
    public function testGenerarTurnos() {
        // Busco si existen turnos reservados de hoy en adelante
        $r = $this->Turno->find('count', array('conditions' =>
            array('`Turno`.`paciente_id` IS NOT NULL',
                '`Turno`.`fecha_fin` >=' => date('Y-m-d')),
                'recursive' => -1)
        );
        $this->assertEqual( $r, 0, "Existen turnos reservados en los datos. No se continuará el proceso.");
    }

    /**
     * Verifica que se devuelvan los años correspondientes al maximo y minimo
     */
    public function testMax() {
        // Veo de tomar los datos correspondientes
        $max = $this->Turno->find('first', array('recursive' => -1, 'fields' => array('fecha_inicio'), 'order' => array('fecha_inicio' => 'desc')));
        $ano_max = intval(date('Y', strtotime($max['Turno']['fecha_inicio'])));
        $this->assertNotEqual($ano_max, null, "La fecha maxima de comparacion no puede ser nula");
        $this->assertNotEqual($ano_max, 0, "La fecha máxima de comparación no puede ser cero");
        $this->assertEqual($this->Turno->anoMaximoTurno(), $ano_max, "La fecha obtenida por el modelo no coincide");
    }

    /**
     * Verifica que se devuelvan los años correspondientes al maximo y minimo
     */
    public function testMin() {
        // Veo de tomar los datos correspondientes
        $min = $this->Turno->find('first', array('recursive' => -1, 'fields' => array('fecha_inicio'), 'order' => array('fecha_inicio' => 'asc')));
        $ano_min = intval(date('Y', strtotime($min['Turno']['fecha_inicio'])));
        $this->assertNotEqual($ano_min, null, "La fecha minima de comparacion no puede ser nula");
        $this->assertNotEqual($ano_min, 0, "La fecha minima de comparación no puede ser cero");
        $this->assertEqual($this->Turno->anoMinimoTurno(), $ano_min, "La fecha obtenida por el modelo no coincide");
    }

    /* public function testCantidadTurnos() {
      $this->assertEqual( $this->Turno->cantidadDia(), 1, "Los turnos del día de hoy deben ser cero" );
      $this->assertEqual( $this->Turno->cantidadDia( $fecha ), 0, "Los turnos del año pasado no deben ser distintos de 0" );
      $this->assertEqual( $this->Turno->cantidadDia( $fecha_buena ), 10, "Los turnos de los datos deben ser 10" );
      ///@TODO Agregar restricciones extras
      }

      public function testCantidadAtendidos() {
      $this->assertEqual( $this->Turno->cantidadDiaAtendidos(), 1, "Los turnos del día de hoy deben ser cero" );
      $this->assertEqual( $this->Turno->cantidadDiaAtendidos( $fecha ), 0, "Los turnos del año pasado no deben ser distintos de 0" );
      $this->assertEqual( $this->Turno->cantidadDiaAtendidos( $fecha_buena ), 10, "Los turnos de los datos deben ser 10" );
      ///@TODO Agregar restricciones extras
      }

      public function testCantidadRecibidos() {
      $this->assertEqual( $this->Turno->cantidadDiaRecibidos(), 1, "Los turnos del día de hoy deben ser cero" );
      $this->assertEqual( $this->Turno->cantidadDiaRecibidos( $fecha ), 0, "Los turnos del año pasado no deben ser distintos de 0" );
      $this->assertEqual( $this->Turno->cantidadDiaRecibidos( $fecha_buena ), 10, "Los turnos de los datos deben ser 10" );
      ///@TODO Agregar restricciones extras
      }

      public function testCantidadLibres() {
      $this->assertEqual( $this->Turno->cantidadDiaLibres(), 1, "Los turnos del día de hoy deben ser cero" );
      $this->assertEqual( $this->Turno->cantidadDiaLibres( $fecha ), 0, "Los turnos del año pasado no deben ser distintos de 0" );
      $this->assertEqual( $this->Turno->cantidadDiaLibres( $fecha_buena ), 10, "Los turnos de los datos deben ser 10" );
      ///@TODO Agregar restricciones extras
      }

      public function testCantidadReservados() {
      $this->assertEqual( $this->Turno->cantidadDiaReservados(), 1, "Los turnos del día de hoy deben ser cero" );
      $this->assertEqual( $this->Turno->cantidadDiaReservados( $fecha ), 0, "Los turnos del año pasado no deben ser distintos de 0" );
      $this->assertEqual( $this->Turno->cantidadDiaReservados( $fecha_buena ), 10, "Los turnos de los datos deben ser 10" );
      ///@TODO Agregar restricciones extras
      } */

    /* !
     * Pruebo que genera la condiciones necesarias para generar un nuevo traslado de turno a otro horario
     * Turnos id = 12 -> <12
     */
    public function testTrasladoTurno() {
        $turno = $this->Turno->find('first', array('conditions' => array('id_turno' => 12), 'recursive' => -1));
        $this->assertArrayHasKey('Turno', $turno, "El turno de origen no puede ser nulo");
        $this->assertEqual($turno['Turno']['id_turno'], 12, "El turno de origen es incorrecto");
        $id_paciente = $turno['Turno']['paciente_id'];

        $this->assertEqual($this->Turno->trasladarTurno(12, 11), true, "El turno no se pudo hacer como traslado");

        $turno2 = $this->Turno->find('first', array('conditions' => array('id_turno' => 11), 'recursive' => -1));
        $this->assertArrayHasKey('Turno', $turno2, "El turno trasladado no tiene datos!");
        $this->assertEqual($turno2['Turno']['paciente_id'], $id_paciente, "El paciente traslado no corresponde con el original");

        unset($truno);
        $turno = $this->Turno->find('first', array('conditions' => array('id_turno' => 12), 'recursive' => -1));
        $this->assertArrayHasKey('Turno', $turno, "El turno original no se pudo releer!");
        $this->assertEqual($turno['Turno']['paciente_id'], null, "El turno original no tiene dato de paciente reestablecido");
    }

    /* !
     * Funcion que prueba que el sistema falla si se intenta trasladar un turno a otro ya ocupado
     * Turnos id = 12 -> 13
     */
    public function testTrasladoTurnoOcupado() {
        $turno = $this->Turno->find('first', array('conditions' => array('id_turno' => 12), 'recursive' => -1));
        $this->assertArrayHasKey('Turno', $turno, "El turno de origen no puede ser nulo");
        $this->assertEqual($turno['Turno']['id_turno'], 12, "El turno de origen es incorrecto");

        $this->assertEqual($this->Turno->trasladarTurno(12, 13), false, "El traslado de turno a un turno ocupado no debe suceder!");
    }

    /**
     *
     */
    public function testTrasladoTurnosNulos() {
        $this->assertEqual($this->Turno->trasladarTurno(12, null), false, "El valor devuelto debería ser falso");
        $this->assertEqual($this->Turno->trasladarTurno(null, 13), false, "El valor devuelto debería ser falso");
        $this->assertEqual($this->Turno->trasladarTurno(null, null), false, "El valor devuelto debería ser falso");
    }

    /**
     * Testo de reserva de turnos
     */
    public function testReservaTurnosLibre() {
        $libre = $this->Turno->find( 'first',
                            array( 'conditions' => array(
                                    'paciente_id' => null
                            ),
                            'recursive' => -1,
                            'fields' => array( 'id_turno' ) )
        );
        $this->assertEqual( $this->Turno->reservar( $libre['Turno']['id_turno'] ), true, "No se pudo reservar el turno!" );
    }

    /**
     *
     */
    public function testReservaTurnosOcupado() {
        $libre = $this->Turno->find( 'first',
                            array( 'conditions' => array(
                                    'NOT' => array( 'paciente_id' => null )
                            ),
                            'recursive' => -1,
                            'fields' => array( 'id_turno' ) )
        );
        $this->assertEqual( $this->Turno->reservar( $libre['Turno']['id_turno'] ), false, "No se pudo reservar el turno!" );
    }

    /**
     *
     */
    public function testReservaTurnosCancelado() {
        $libre = $this->Turno->find( 'first',
                            array( 'conditions' => array(
                                   'cancelado' => true
                            ),
                            'recursive' => -1,
                            'fields' => array( 'id_turno' ) )
        );
        $mensaje = '';
        $this->assertEqual( $this->Turno->reservar( $libre['Turno']['id_turno'], 1, $mensaje ), false, "No se pudo reservar el turno!" );
        $this->assertNotEqual( $mensaje, '', "El mensaje es incorrecto" );
        $this->assertEqual( $mensaje, "El turno se encuentra cancelado por el médico.", "Mensaje incorrecto!" );
    }

    /**
     *
     */
    public function testReservaTurnosInexistente() {
        $this->assertEqual( $this->Turno->reservar( null ), false, "No se debe poder reservar el turno nulo" );
    }

    /**
     *
     */
    public function testLiberarTurnoExistente() {
        $libre = $this->Turno->find( 'first',
                            array( 'conditions' => array(
                                   'NOT' => array( 'paciente_id' => null )
                            ),
                            'recursive' => -1,
                            'fields' => array( 'id_turno' ) )
        );
        $this->assertEqual( $this->Turno->liberar( $libre['Turno']['id_turno'] ), true, "No se pudo liberar el turno!" );

        $libre = $this->Turno->find( 'first',
                            array( 'conditions' => array(
                                   'NOT' => array( 'paciente_id' => null )
                            ),
                            'recursive' => -1,
                            'fields' => array( 'id_turno' ) )
        );
        $this->Turno->id = intval( $libre['Turno']['id_turno'] );
        $this->assertEqual( $this->Turno->liberar(), true, "No se pudo liberar el turno por ID!" );
    }

    /**
     *
     */
    public function testLiberarTurnoIncorrecto() {
        $this->assertNotEqual( $this->Turno->liberar( null ), true, "No debe poder liberar un turno nulo" );
        $this->assertNotEqual( $this->Turno->liberar(), true, "No se debe poder liberar un turno nulo x ID" );
    }

    /**
     *
     */
    public function testLiberarTurnoExistenteNoReservado() {
        $libre = $this->Turno->find( 'first',
                            array( 'conditions' => array(
                                   'paciente_id' => null
                            ),
                            'recursive' => -1,
                            'fields' => array( 'id_turno' ) )
        );
        $this->assertEqual( $this->Turno->liberar( $libre['Turno']['id_turno'] ), true, "No se pudo liberar el turno!" );

        $libre = $this->Turno->find( 'first',
                            array( 'conditions' => array(
                                   'paciente_id' => null
                            ),
                            'recursive' => -1,
                            'fields' => array( 'id_turno' ) )
        );
        $this->Turno->id = intval( $libre['Turno']['id_turno'] );
        $this->assertEqual( $this->Turno->liberar( null ), true, "No se pudo liberar el turno por ID!" );
    }

    /**
     * Testea la funcion de turno reservado
     */
    public function testTurnoReservadoReservado() {
        $reservado = $this->Turno->find( 'first',
                            array( 'conditions' => array(
                                   'NOT' => array( 'paciente_id' => null ),
                                   'cancelado' => false
                            ),
                            'recursive' => -1,
                            'fields' => array( 'id_turno' ) )
        );
        $id_turno = intval( $reservado['Turno']['id_turno'] );
        $this->assertEqual( $this->Turno->reservado( $id_turno ), true, "El turno debería de estar reservado pasando como parametro");

        $this->Turno->id = $id_turno;
        $this->assertEqual( $this->Turno->reservado(), true, "La funcion debería de devolver falso x ID" );
    }

    /**
     *
     */
    public function testTurnoReservadoCancelado() {
        $reservado = $this->Turno->find( 'first',
                            array( 'conditions' => array(
                                   'cancelado' => true  /// @TODO: Verificar si con paciente_id != null se da el caso
                            ),
                            'recursive' => -1,
                            'fields' => array( 'id_turno' ) )
        );
        $id_turno = intval( $reservado['Turno']['id_turno'] );
        $this->assertEqual( $this->Turno->reservado( $id_turno ), false );

        $this->Turno->id = $id_turno;
        $this->assertEqual( $this->Turno->reservado(), false, "La funcion debería de devolver falso x ID" );
    }

    /**
     *
     */
    public function testTurnoReservadoLiberado() {
        $libre = $this->Turno->find( 'first',
                            array( 'conditions' => array(
                                   'paciente_id' => null,
                                   'cancelado' => false
                            ),
                            'recursive' => -1,
                            'fields' => array( 'id_turno' ) )
        );
        $id_turno = intval( $libre['Turno']['id_turno'] );
        $this->assertEqual( $this->Turno->reservado( $id_turno ), false, "La funcion debería devolver falso" );

        $this->Turno->id = $id_turno;
        $this->assertEqual( $this->Turno->reservado(), false, "La funcion debería de devolver falso x ID" );
    }

    /**
     *
     */
    public function testTurnoReservadoInvalido() {
        $id_turno = -1;
        $this->assertEqual( $this->Turno->reservado( $id_turno ), false );

        $this->Turno->id = $id_turno;
        $this->assertEqual( $this->Turno->reservado(), false, "La funcion debería de devolver falso x ID" );
    }

    /**
     *
     */
    public function testTurnoReservadoParametroCruzado() {
        $libre = $this->Turno->find( 'first',
                            array( 'conditions' => array(
                                   'paciente_id' => null,
                                   'cancelado' => false
                            ),
                            'recursive' => -1,
                            'fields' => array( 'id_turno' ) )
        );
        $id_turno = intval( $libre['Turno']['id_turno'] );
        $this->assertEqual( $this->Turno->reservado( $id_turno ), false, "La funcion debería devolver falso" );

        $this->Turno->id = 5;
        $this->assertEqual( $this->Turno->reservado(), false, "La funcion debería de devolver falso x ID" );
        $this->assertEqual( $this->Turno->reservado( $id_turno ), false, "La funcion debería devolver verdadero aunque el ID sea nulo" );
    }

    /**
     *
     */
    public function testTurnoReservadoParametroNulo() {
        $id_turno = null;
        $this->assertEqual( $this->Turno->reservado( $id_turno ), false );

        $this->Turno->id = $id_turno;
        $this->assertEqual( $this->Turno->reservado(), false, "La funcion debería de devolver falso x ID" );
    }

    /*!
     * Busca la lista de turnos a los cuales se puede trasladar los turnos que estan luego del pasado como parametro
     */
    public function testTrasladoTurnosBuscarTurnos() {
        $turno = $this->Turno->find( 'first', array( 'conditions' => array( 'paciente_id IS NOT NULL' ),
                                                        'recursive' => -1,
                                                        'fields' => array( 'id_turno', 'fecha_inicio', 'medico_id' ),
                                                        'order' => array( 'id_turno' => 'asc' ) ) );
        $this->assertArrayHasKey( 'Turno', $turno, "No se econtro un turno para hacer el test - verifique el fixture" );
        $fecha_turno_original = $turno['Turno']['fecha_inicio'];
        $id_turno = intval( $turno['Turno']['id_turno'] );
        $id_medico = intval( $turno['Turno']['medico_id'] );

        $this->assertNotEqual( $id_turno, 0, "El numero de turno no puede ser cero" );
        $this->assertEqual( $this->Turno->buscarTurnosParaTraslado(), false, "El pasar sin parametros debe devolver falso" );
        $this->assertEqual( $this->Turno->buscarTurnosParaTraslado( null ), false, "El pasar parametro nulo debe devolver falso" );
        $this->assertEqual( $this->Turno->buscarTurnosParaTraslado( 0 ), false, "El pasar parametro cero debe devolver falso" );
        $this->assertEqual( $this->Turno->buscarTUrnosParaTraslado( -1 ), false, "El pasar parametro negativo debe devolver falso" );

        $nuevos_turnos = $this->Turno->buscarTurnosParaTraslado( $id_turno );
        $this->assertNotEqual( count( $nuevos_turnos ), 0, "No se debería devolver array vacío - verifique el fixture" );
        foreach( $nuevos_turnos as $key => $turno ) {
            $this->assertArrayHasKey( 'Turno', $turno, "El array debería tener el formato cake estandar ".$key );
            $this->assertArrayHasKey( 'fecha_inicio', $turno['Turno'], "El array debería de tener la fecha de inicio" );
            $this->assertArrayHasKey( 'medico_id', $turno['Turno'] );
            $this->assertEqual( intval( $turno['Turno']['medico_id'] ), $id_medico, "No coincide el identificador del medico que desea trasladar el turno" );
            $this->assertNotEqual( $turno['Turno']['id_turno'], $id_turno, "El turno seleccionado no puede ser igual al original" );
            $this->assertGreaterThan( $fecha_turno_original, $turno['Turno']['fecha_inicio'], "La fecha seleccionada debería de ser mayor a la del turno elegido" );
            $this->assertArrayHasKey( 'Medico', $turno );
            $this->assertArrayHasKey( 'Consultorio', $turno );
        }

    }
    
    /**
     * 
     */
    public function testTestEliminarUsuario() {
        $data = $this->Turno->find( 'first', array( 'conditions' => array( 'NOT' => array( 'paciente_id' => null ) ),
                                                    'recursive' => -1,
                                                    'fields' => array( 'paciente_id' )
                                             )
        );
        $id_usuario = intval( $data[$this->Turno->alias]['paciente_id'] );
        
        $cantidad = $this->Turno->find( 'count', array( 'conditions' => array( 'paciente_id' => $id_usuario ) ) );
        $this->assertNotEqual( $cantidad, 0 );
        
        $this->assertNotEqual( $this->Turno->eliminarTurnosUsuario( $id_usuario ), false );
        
        $cantidad = $this->Turno->find( 'count', array( 'conditions' => array( 'paciente_id' => $id_usuario ) ) );
        $this->assertEqual( $cantidad, 0 );
    }

    /**
     * 
     */
    public function testTestEliminarUsuarioInvalido() {
        $this->assertEqual( $this->Turno->eliminarTurnosUsuario( null ), false );
    }
    
    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown() {
        unset($this->Turno);
        parent::tearDown();
    }

}
