<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SaleTransactionsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SaleTransactionsTable Test Case
 */
class SaleTransactionsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SaleTransactionsTable
     */
    protected $SaleTransactions;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.SaleTransactions',
        'app.Employees',
        'app.Customers',
        'app.Stocks',
        'app.SalePayments',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SaleTransactions') ? [] : ['className' => SaleTransactionsTable::class];
        $this->SaleTransactions = $this->getTableLocator()->get('SaleTransactions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SaleTransactions);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SaleTransactionsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SaleTransactionsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
