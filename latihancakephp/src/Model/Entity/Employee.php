<?php

declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * Employee Entity
 *
 * @property int $id
 * @property string $username
 * @property string $fullname
 * @property string $role
 * @property string $phone
 * @property string $email
 * @property string $address
 * @property string $password
 * @property \Cake\I18n\FrozenTime $last_login
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\PurchaseTransaction[] $purchase_transactions
 * @property \App\Model\Entity\SaleTransaction[] $sale_transactions
 */
class Employee extends Entity
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
        'username' => true,
        'fullname' => true,
        'role' => true,
        'phone' => true,
        'email' => true,
        'address' => true,
        'last_login' => true,
        'created' => true,
        'modified' => true,
        'customers' => true,
        'purchase_transactions' => true,
        'sale_transactions' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected $_hidden = [
        'password',
    ];

    protected $_virtual = ['full_description'];  // Menambahkan virtual field

    protected function _getFullDescription()
    {
        return $this->fullname . ' ' . $this->role;
    }

    // Automatically hash passwords when they are changed.
    protected function _setPassword(string $password)
    {
        $hasher = new DefaultPasswordHasher();
        return $hasher->hash($password);
    }
}