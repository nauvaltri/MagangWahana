<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SaleTransactionsFixture
 */
class SaleTransactionsFixture extends TestFixture
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
                'customer_id' => 1,
                'stock_id' => 1,
                'price' => 1,
                'quantity' => 1,
                'total_price' => 1,
                'transaction_date' => '2024-09-10 06:42:04',
                'created' => '2024-09-10 06:42:04',
                'modified' => '2024-09-10 06:42:04',
            ],
        ];
        parent::init();
    }
}
