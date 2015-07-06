<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Consultorio Entity.
 */
class Consultorio extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'clinica_id' => true,
        'nombre' => true,
        'clinica' => true,
        'disponibilidad' => true,
        'turnos' => true,
    ];
}
