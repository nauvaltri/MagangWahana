<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Stock Entity
 *
 * @property int $id
 * @property string $merk
 * @property string $model
 * @property string $engine_capacity
 * @property string $color
 * @property string $production_year
 * @property int $price
 * @property int $quantity
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class Stock extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'merk' => true,
        'model' => true,
        'engine_capacity' => true,
        'color' => true,
        'production_year' => true,
        'price' => true,
        'quantity' => true,
        'created' => true,
        'modified' => true,
    ];
}
