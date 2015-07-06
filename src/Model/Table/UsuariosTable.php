<?php
namespace App\Model\Table;

use App\Model\Entity\Usuario;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Usuarios Model
 *
 * @property \Cake\ORM\Association\BelongsTo $ObraSocials
 * @property \Cake\ORM\Association\BelongsTo $Grupos
 * @property \Cake\ORM\Association\BelongsTo $Facebooks
 * @property \Cake\ORM\Association\HasMany $BakerRepositorios
 * @property \Cake\ORM\Association\HasMany $Medicos
 * @property \Cake\ORM\Association\HasMany $Secretarias
 */
class UsuariosTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('usuarios');
        $this->displayField('id_usuario');
        $this->primaryKey('id_usuario');
        $this->belongsTo('ObraSocials', [
            'foreignKey' => 'obra_social_id'
        ]);
        $this->belongsTo('Grupos', [
            'foreignKey' => 'grupo_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Facebooks', [
            'foreignKey' => 'facebook_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('BakerRepositorios', [
            'foreignKey' => 'usuario_id'
        ]);
        $this->hasMany('Medicos', [
            'foreignKey' => 'usuario_id'
        ]);
        $this->hasMany('Secretarias', [
            'foreignKey' => 'usuario_id'
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
            ->add('id_usuario', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id_usuario', 'create');
            
        $validator
            ->add('email', 'valid', ['rule' => 'email'])
            ->requirePresence('email', 'create')
            ->notEmpty('email');
            
        $validator
            ->requirePresence('nombre', 'create')
            ->notEmpty('nombre');
            
        $validator
            ->requirePresence('apellido', 'create')
            ->notEmpty('apellido');
            
        $validator
            ->requirePresence('telefono', 'create')
            ->notEmpty('telefono');
            
        $validator
            ->requirePresence('celular', 'create')
            ->notEmpty('celular');
            
        $validator
            ->add('notificaciones', 'valid', ['rule' => 'boolean'])
            ->requirePresence('notificaciones', 'create')
            ->notEmpty('notificaciones');
            
        $validator
            ->requirePresence('contra', 'create')
            ->notEmpty('contra');
            
        $validator
            ->requirePresence('sexo', 'create')
            ->notEmpty('sexo');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->existsIn(['obra_social_id'], 'ObraSocials'));
        $rules->add($rules->existsIn(['grupo_id'], 'Grupos'));
        $rules->add($rules->existsIn(['facebook_id'], 'Facebooks'));
        return $rules;
    }
}
