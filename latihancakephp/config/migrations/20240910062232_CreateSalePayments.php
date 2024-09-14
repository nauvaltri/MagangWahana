<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateSalePayments extends AbstractMigration
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
        $table = $this->table('sale_payments');
        $table->addColumn('sale_transaction_id', 'integer', ['null' => false]);
        $table->addForeignKey('sale_transaction_id', 'sale_transactions', 'id', [
            'constraint' => 'fk_sale_payments_sale_transactions'
        ]);
        $table->addColumn('nominal', 'integer', ['null' => false]);
        $table->addColumn('payment_method', 'string', ['limit' => 50, 'null' => false]);
        $table->addColumn('status', 'string', ['limit' => 50, 'null' => false]);
        $table->addColumn('payment_date', 'datetime');
        $table->addColumn('proof', 'string', ['limit' => 255]);
        $table->addColumn('created', 'datetime', ['null' => false]);
        $table->addColumn('modified', 'datetime', ['null' => false]);
        $table->create();
    }
}
