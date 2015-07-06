<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Medico Entity.
 */
class Medico extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'usuario_id' => true,
        'especialidad_id' => true,
        'clinica_id' => true,
        'visible' => true,
        'usuario' => true,
        'especialidad' => true,
        'clinica' => true,
        'disponibilidad' => true,
        'excepciones' => true,
        'turnos' => true,
    ];
}
