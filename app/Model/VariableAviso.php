<?php
App::uses('AppModel', 'Model');
/**
 * Modelo para los avisos
 *
 */
class VariableAviso extends AppModel {
	public $useTable = 'variables_avisos';
	public $primaryKey = 'id_variable';
}