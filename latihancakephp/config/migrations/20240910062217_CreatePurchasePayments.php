<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreatePurchasePayments extends AbstractMigration
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
        $table = $this->table('purchase_payments');
        $table->addColumn('purchase_transaction_id', 'integer', ['null' => false]);
        $table->addForeignKey('purchase_transaction_id', 'purchase_transactions', 'id', [
            'constraint' => 'fk_purchase_payments_purchase_transactions'
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
