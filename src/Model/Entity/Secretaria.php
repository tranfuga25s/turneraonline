<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Secretaria Entity.
 */
class Secretaria extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'usuario_id' => true,
        'clinica_id' => true,
        'resumen' => true,
        'usuario' => true,
        'clinica' => true,
    ];
}
