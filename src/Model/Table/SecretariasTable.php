<?php
namespace App\Model\Table;

use App\Model\Entity\Secretaria;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Secretarias Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Usuarios
 * @property \Cake\ORM\Association\BelongsTo $Clinicas
 */
class SecretariasTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('secretarias');
        $this->displayField('id_secretaria');
        $this->primaryKey('id_secretaria');
        $this->belongsTo('Usuarios', [
            'foreignKey' => 'usuario_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Clinicas', [
            'foreignKey' => 'clinica_id',
            'joinType' => 'INNER'
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
            ->add('id_secretaria', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id_secretaria', 'create');
            
        $validator
            ->add('resumen', 'valid', ['rule' => 'boolean'])
            ->requirePresence('resumen', 'create')
            ->notEmpty('resumen');

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
        $rules->add($rules->existsIn(['clinica_id'], 'Clinicas'));
        return $rules;
    }
}
