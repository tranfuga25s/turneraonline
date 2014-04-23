<?php

App::uses('AppModel', 'Model');

/**
 * Modelo para la administración de los medicos declarados en el sistema.
 *
 * @property Usuario $Usuario
 * @property Especialidad $Especialidad
 * @property Clinica $Clinica
 * @property Turno $Turno
 * @property Disponibilidad $Disponibilidad
 */
class Medico extends AppModel {

    public $primaryKey = 'id_medico';
    public $actAs = array('AuditLog.Auditable');
    public $validate = array(
        'usuario_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Por favor, ingrese un usuario para asociar al medico.',
                'allowEmpty' => false,
                'required' => true,
                'on' => 'create'
            )
        )
    );

    /**
     * Asociaciones a donde pertenece el medico
     * @var array
     */
    public $belongsTo = array(
        'Usuario' => array(
            'className' => 'Usuario',
            'foreignKey' => 'usuario_id',
            'dependent' => true,
        ),
        'Especialidad' => array(
            'className' => 'Especialidad',
            'foreignKey' => 'especialidad_id',
        ),
        'Clinica' => array(
            'className' => 'Clinica',
            'foreignKey' => 'clinica_id',
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Turno' => array(
            'className' => 'Turno',
            'foreignKey' => 'medico_id',
        ),
            /* 'Excepcion' => array(
              'className' => 'Excepcion',
              'foreignKey' => 'medico_id'
              ) */
    );

    /**
     *
     * @var array
     */
    public $hasOne = array(
        'Disponibilidad' => array(
            'className' => 'Disponibilidad',
            'dependent' => true
        )
    );

    /**
     * Devuleve el listado de medicos como para un select
     * @param integer $id_filtro Identificador del filtro que estamos buscando
     * @param boolean $solo_visibles Muestra solo los medicos visibles
     * @return array Lista de medicos ( ID_usuario > razonsocial )
     */
    public function lista($id_filtro = null, $solo_visibles = false) {
        $cond = array('grupo_id' => 2);
        if ( $id_filtro != null ) {
            $cond['id_usuario'] = $id_filtro;
        } 
        if ($solo_visibles) {
            $ids = $this->find('list', array('conditions' => array('visible' => true ), 'fields' => array( 'usuario_id' ) ) );
            if ( $id_filtro != null ) {
                $ids_autorizados = array_intersect( $ids, array( $id_filtro ) );
                if(array_key_exists( $id_filtro, array_flip( $ids_autorizados ) ) ) {
                    $cond['id_usuario'] = $id_filtro;
                } else {
                    return array();
                }
            } else {
                $cond['id_usuario'] = $ids;
            }
        }
        return $this->Usuario->find( 'list', 
                    array( 'conditions' => $cond, 
                           'fields' => array( 'id_usuario', 'razonsocial' )
        ));
    }

    /**
     * Muestra la lista de medicos que tienen la propiedad de visible seteada como verdadera.
     * Si se pasa como parametro algún ID de medico especifico, se mostrará solo la información de ese médico, sin importar si se encuentra visible o no.
     * El formato de devolución es un array con [$id_medico] => $razonsocial
     * \param id_filtro Identificador a filtrar.
     * \return array con el formato $id_medico => $razonsocial
     */
    public function lista2($id_filtro = null) {
        $cond = array();
        $ids = $this->find('list', array('conditions' => array('visible' => true), 'fields' => array('id_medico')));
        if (count($ids > 0) && $id_filtro == null) {
            $cond = array('id_medico' => $ids);
        } else if (count($ids <= 0) && $id_filtro == null) {
            return array();
        } else {
            // Filtro los medicos pasados como parametros con los de la lista de visibles
            if (is_array($id_filtro)) {
                $resultado = array_intersect($id_filtro, $ids);
            } else {
                if (in_array($id_filtro, $ids)) {
                    $resultado = array($id_filtro);
                } else {
                    $resultado = array();
                }
            }
            $cond = array('id_medico' => $resultado);
        }
        $lista = $this->find('list', array('conditions' => $cond, 'fields' => array('id_medico', 'usuario_id')));
        $lusuario = $this->Usuario->find('list', array('conditions' => array('grupo_id' => 2), 'fields' => array('id_usuario', 'razonsocial')));
        foreach ($lista as $id_med => $id_us) {
            if (array_key_exists($id_us, $lusuario)) {
                $lista[$id_med] = $lusuario[$id_us];
            }
        }
        return $lista;
    }

    /**
     * Función de eliminación de medicos
     * Tiene la facilidad de eliminar todos los turnos ( previa cancelación ) y la disponibilidades asociadas.
     * \param $id_medico Identificador del medico
     * \return Verdadero si se pudo eliminar el médico
     */
    public function eliminar($id_medico) {
        $turnos = $this->Turno->find('list', array('conditions' => array('medico_id' => $id_medico)));
        foreach ($turnos as $turno) {
            $this->Turno->cancelar($turno);
            if (!$this->Turno->delete($turno)) {
                return false;
            }
        }
        // Disponibilidad
        if (!$this->Disponibilidad->deleteAll(array('medico_id' => $id_medico), true)) {
            return false;
        }
        // Excepcion
        // Finalmente elimino el medico
        return $this->delete($id_medico);
    }

    /* !
     * Devuelve el listado de medicos publicados según una clínica
     * @param integer $id_clinica Identificador de la clinica
     */

    public function listaPorClinica($id_clinica) {
        $lista = $this->find('list', array('conditions' => array('clinica_id' => $id_clinica, 'visible' => true), 'fields' => array('id_medico', 'usuario_id')));
        $lusuario = $this->Usuario->find('list', array('conditions' => array('grupo_id' => 2), 'fields' => array('id_usuario', 'razonsocial')));
        foreach ($lista as $id_med => $id_us) {
            if (array_key_exists($id_us, $lusuario)) {
                $lista[$id_med] = $lusuario[$id_us];
            }
        }
        return $lista;
    }

}
