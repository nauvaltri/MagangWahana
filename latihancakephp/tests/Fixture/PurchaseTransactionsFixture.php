<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PurchaseTransactionsFixture
 */
class PurchaseTransactionsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'employee_id' => 1,
                'purchase_id' => 1,
                'price' => 1,
                'quantity' => 1,
                'total_price' => 1,
                'transaction_date' => '2024-09-10 06:33:37',
                'created' => '2024-09-10 06:33:37',
                'modified' => '2024-09-10 06:33:37',
                'code' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
