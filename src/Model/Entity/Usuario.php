<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Usuario Entity.
 */
class Usuario extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'email' => true,
        'nombre' => true,
        'apellido' => true,
        'telefono' => true,
        'celular' => true,
        'obra_social_id' => true,
        'notificaciones' => true,
        'contra' => true,
        'grupo_id' => true,
        'facebook_id' => true,
        'sexo' => true,
        'obra_social' => true,
        'grupo' => true,
        'facebook' => true,
        'baker_repositorios' => true,
        'medicos' => true,
        'secretarias' => true,
    ];
}
