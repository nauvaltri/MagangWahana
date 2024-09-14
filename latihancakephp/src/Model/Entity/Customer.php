<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property int $id
 * @property string $name
 * @property string $nik
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\SaleTransaction[] $sale_transactions
 */
class Customer extends Entity
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
        'name' => true,
        'nik' => true,
        'phone' => true,
        'email' => true,
        'address' => true,
        'created' => true,
        'modified' => true,
        'created_by' => true,
        'modified_by' => true,
        'sale_transactions' => true,
    ];

    protected $_virtual = ['full_description'];  // Menambahkan virtual field

    protected function _getFullDescription()
    {
        return $this->name . ' ' . $this->nik;
    }
}