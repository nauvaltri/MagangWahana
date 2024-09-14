<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SalePaymentsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SalePaymentsTable Test Case
 */
class SalePaymentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SalePaymentsTable
     */
    protected $SalePayments;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.SalePayments',
        'app.SaleTransactions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SalePayments') ? [] : ['className' => SalePaymentsTable::class];
        $this->SalePayments = $this->getTableLocator()->get('SalePayments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SalePayments);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SalePaymentsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SalePaymentsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
