<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PurchasePayment Entity
 *
 * @property int $id
 * @property int $purchase_transaction_id
 * @property int $nominal
 * @property string $payment_method
 * @property string $status
 * @property \Cake\I18n\FrozenTime $payment_date
 * @property string $proof
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\PurchaseTransaction $purchase_transaction
 */
class PurchasePayment extends Entity
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
        'purchase_transaction_id' => true,
        'nominal' => true,
        'payment_method' => true,
        'status' => true,
        'payment_date' => true,
        'proof' => true,
        'created' => true,
        'modified' => true,
        'purchase_transaction' => true,
    ];
}
