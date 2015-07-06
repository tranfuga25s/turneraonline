<?php
namespace App\Model\Table;

use App\Model\Entity\Clinica;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Clinicas Model
 *
 * @property \Cake\ORM\Association\HasMany $Consultorios
 * @property \Cake\ORM\Association\HasMany $Medicos
 * @property \Cake\ORM\Association\HasMany $Secretarias
 */
class ClinicasTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('clinicas');
        $this->displayField('nombre');
        $this->primaryKey('id_clinica');
        $this->hasMany('Consultorios', [
            'foreignKey' => 'clinica_id'
        ]);
        $this->hasMany('Medicos', [
            'foreignKey' => 'clinica_id'
        ]);
        $this->hasMany('Secretarias', [
            'foreignKey' => 'clinica_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id_clinica', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id_clinica', 'create');
            
        $validator
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');
            
        $validator
            ->requirePresence('direccion', 'create')
            ->notEmpty('direccion');
            
        $validator
            ->add('telefono', 'valid', ['rule' => 'numeric'])
            ->requirePresence('telefono', 'create')
            ->notEmpty('telefono');
            
        $validator
            ->add('email', 'valid', ['rule' => 'email'])
            ->requirePresence('email', 'create')
            ->notEmpty('email');
            
        $validator
            ->requirePresence('logo', 'create')
            ->notEmpty('logo');
            
        $validator
            ->allowEmpty('lat');
            
        $validator
            ->allowEmpty('lng');
            
        $validator
            ->allowEmpty('zoom');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email', 'nombre']));
        return $rules;
    }
}
