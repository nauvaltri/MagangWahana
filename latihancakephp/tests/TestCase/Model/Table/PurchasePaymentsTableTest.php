<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PurchasePaymentsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PurchasePaymentsTable Test Case
 */
class PurchasePaymentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PurchasePaymentsTable
     */
    protected $PurchasePayments;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.PurchasePayments',
        'app.PurchaseTransactions',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PurchasePayments') ? [] : ['className' => PurchasePaymentsTable::class];
        $this->PurchasePayments = $this->getTableLocator()->get('PurchasePayments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PurchasePayments);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PurchasePaymentsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PurchasePaymentsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
