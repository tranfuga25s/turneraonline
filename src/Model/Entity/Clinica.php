<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Clinica Entity.
 * @author Esteban Zeller <esteban.zeller@gmail.com>
 */
class Clinica extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'nombre' => true,
        'direccion' => true,
        'telefono' => true,
        'email' => true,
        'logo' => true,
        'lat' => true,
        'lng' => true,
        'zoom' => true,
        'consultorios' => true,
        'medicos' => true,
        'secretarias' => true,
    ];
}
