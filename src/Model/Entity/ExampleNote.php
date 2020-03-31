<?php
declare(strict_types=1);

namespace ExampleModule\Model\Entity;

use Cake\ORM\Entity;

/**
 * ExampleNote Entity
 *
 * @property int $id
 * @property int $host_id
 * @property string $notes
 *
 * @property \ExampleModule\Model\Entity\Host $host
 */
class ExampleNote extends Entity {
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'host_id' => true,
        'notes'   => true,
        'host'    => true,
    ];
}
