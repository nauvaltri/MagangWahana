<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PurchasesFixture
 */
class PurchasesFixture extends TestFixture
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
                'supplier_id' => 1,
                'merk' => 'Lorem ipsum dolor sit amet',
                'model' => 'Lorem ipsum dolor sit amet',
                'engine_capacity' => 'Lorem ipsum dolor ',
                'color' => 'Lorem ipsum dolor sit amet',
                'production_year' => 'Lorem ipsum dolor ',
                'price' => 1,
                'created' => '2024-09-10 06:10:31',
                'modified' => '2024-09-10 06:10:31',
            ],
        ];
        parent::init();
    }
}
