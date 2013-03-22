<?php
App::uses('AppModel', 'Model');
/**
 * ObrasSocial Model
 *
 */
class ObraSocial extends AppModel {

   /**
    * Tabla utilizada
    * @property string $useTable
    */
	public $useTable = 'obras_sociales';
	
   /**
    * Clave primaria
    * @property string $primaryKey
    */
	public $primaryKey = 'id_obra_social';
	
   /**
    * Campo a mostrar
    * @property string $displatField
    */
	public $displayField = 'nombre';
	
	public $actAs = array( 'AuditLog.Auditable' );
	
   /**
    * Ubicación de la carepta donde se guardaran los logos de las obras sociales
    * app/webroot/img/obra_social/
    * @property mixed $ubicacion_logos
    */
	public $ubicacion_logos = 'obra_social/';
	
   /**
    * Relaciones -> Usuarios <-> Obra social
    */	
    public $hasMany = array(
    	'Usuarios' => array(
    		'className' => 'Usuarios',
    		'foreignKey' => 'obra_social_id',
    		'dependent' => false
		)
	);
	
	public $validate = array(
		'nombre' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Por favor, ingrese un nombre para la obra social'
			),
			'repetido' => array(
				'rule' => array( 'buscarRepetido' ),
				'message' => 'La obra social elegida ya existe.'
			)
		),
		'telefono' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'El numero de telefono debe ser solo numeros',
				'allowEmpty' => true
			)
		)
	);
	
   /**
    * Funcion que busca obras sociales similares
    * @param $valor Valor a buscar
    * @return bool Verdadero si existe algún valor similar
    */	
	public function buscarRepetido( $valor ) {
		$count = $this->find( 'count', array( 'conditions' => array( 'nombre' => $valor['nombre'], $this->primaryKey => '!= '.$this->id ) ) );
		if( $count <= 0 ) {
			return true;
		} else {
			return false;
		}
	}
	
   /**
    * Funcion para manejar los archivos de logos
    * @return bool Verdadero si salió todo bien
    */
	public function beforeSave() {
		// Subo el archivo de logotipo si existe
		if( is_array( $this->data['ObraSocial']['logo'] ) )  { // Acaba de subir el archivo
			// Lo muevo a la posición de los logos de obra social.
			if( $this->data['ObraSocial']['logo']['size'] <= 0 ) {
				echo $this->data['ObraSocial']['logo']['error'];
				return false;
			}
			$nubi = WWW_ROOT.'img'.DS.$this->ubicacion_logos.$this->data['ObraSocial']['id_obra_social'];
			if( rename( $this->data['ObraSocial']['logo']['tmp_name'], $nubi ) ) {
				$this->data['ObraSocial']['logo'] = $this->ubicacion_logo.$this->data['ObraSocial']['id_obra_social'];
				return true;
			} else {
				die( 'Error al copiar el archivo a su ubicación final' );
			}	
		}
	}
	
   /**
    * Funcion para manejar la eliminación de archivos
    * @return bool Verdadero si se puede eliminar
    */
    public function beforeDelete( $cascade = false ) {
	    // Veo si se puede eliminar
	    if( $this->Usuario->find( 'count', array( 'conditions' => array( 'obra_social_id' => $this->id ) ) ) > 0 ) {
	    	$this->validationErrors[] = 'Existen usuarios con esta obra social agregada';
	    	return false;
	    } 
	    // Si se puede eliminar busco el archivo y lo elimino
	    $logo = $this->field( 'logo' );
		unlink( WWW_ROOT.'img'.DS.$logo );
		return true;	    
    } 
 
}
