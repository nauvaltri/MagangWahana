<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateSaleTransactions extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('sale_transactions');
        $table->addColumn('employee_id', 'integer', ['null' => false]);
        $table->addColumn('customer_id', 'integer', ['null' => false]);
        $table->addColumn('stock_id', 'integer', ['null' => false]);
        $table->addForeignKey('employee_id', 'employees', 'id', [
            'constraint' => 'fk_sale_transactions_employees'
        ]);
        $table->addForeignKey('customer_id', 'customers', 'id', [
            'constraint' => 'fk_sale_transactions_customers'
        ]);
        $table->addForeignKey('stock_id', 'stocks', 'id', [
            'constraint' => 'fk_sale_transactions_stocks'
        ]);
        $table->addColumn('price', 'integer', ['null' => false]);
        $table->addColumn('quantity', 'integer', ['null' => false]);
        $table->addColumn('total_price', 'integer', ['null' => false]);
        $table->addColumn('transaction_date', 'datetime', ['null' => false]);
        $table->addColumn('created', 'datetime', ['null' => false]);
        $table->addColumn('modified', 'datetime', ['null' => false]);
        $table->create();
    }
}
