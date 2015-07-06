<?php
namespace App\Model\Table;

use App\Model\Entity\Medico;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Medicos Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Usuarios
 * @property \Cake\ORM\Association\BelongsTo $Especialidads
 * @property \Cake\ORM\Association\BelongsTo $Clinicas
 * @property \Cake\ORM\Association\HasMany $Disponibilidad
 * @property \Cake\ORM\Association\HasMany $Excepciones
 * @property \Cake\ORM\Association\HasMany $Turnos
 */
class MedicosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('medicos');
        $this->displayField('id_medico');
        $this->primaryKey('id_medico');
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Especialidads', [
            'foreignKey' => 'especialidad_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Clinicas', [
            'foreignKey' => 'clinica_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Disponibilidad', [
            'foreignKey' => 'medico_id'
        ]);
        $this->hasMany('Excepciones', [
            'foreignKey' => 'medico_id'
        ]);
        $this->hasMany('Turnos', [
            'foreignKey' => 'medico_id'
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
            ->add('id_medico', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id_medico', 'create');
            
        $validator
            ->add('visible', 'valid', ['rule' => 'boolean'])
            ->requirePresence('visible', 'create')
            ->notEmpty('visible');

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
        $rules->add($rules->existsIn(['usuario_id'], 'Usuarios'));
        $rules->add($rules->existsIn(['especialidad_id'], 'Especialidads'));
        $rules->add($rules->existsIn(['clinica_id'], 'Clinicas'));
        return $rules;
    }
}
