<?php
namespace App\Model\Table;

use App\Model\Entity\Consultorio;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Consultorios Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Clinicas
 * @property \Cake\ORM\Association\HasMany $Disponibilidad
 * @property \Cake\ORM\Association\HasMany $Turnos
 */
class ConsultoriosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('consultorios');
        $this->displayField('id_consultorio');
        $this->primaryKey('id_consultorio');
        $this->belongsTo('Clinicas', [
            'foreignKey' => 'clinica_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Disponibilidad', [
            'foreignKey' => 'consultorio_id'
        ]);
        $this->hasMany('Turnos', [
            'foreignKey' => 'consultorio_id'
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
            ->add('id_consultorio', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id_consultorio', 'create');
            
        $validator
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');

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
        $rules->add($rules->existsIn(['clinica_id'], 'Clinicas'));
        return $rules;
    }
}
