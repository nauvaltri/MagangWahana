<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class AddCreatedByModifiedByToAll extends AbstractMigration
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
        $table1 = $this->table('customers');
        $table1->addColumn('created_by', 'integer', [
            'limit' => 50,
            'null' => false,
            'default' => 1
        ]);
        $table1->addColumn('modified_by', 'integer', [
            'limit' => 50,
            'null' => false,
            'default' => 1
        ]);
        $table1->addForeignKey('created_by', 'employees', 'id', [
            'constraint' => 'fk_customers_created_by'
        ]);
        $table1->addForeignKey('modified_by', 'employees', 'id', [
            'constraint' => 'fk_customers_modified_by'
        ]);
        $table1->update();

        $table2 = $this->table('suppliers');
        $table2->addColumn('created_by', 'integer', [
            'limit' => 50,
            'null' => false,
            'default' => 1
        ]);
        $table2->addColumn('modified_by', 'integer', [
            'limit' => 50,
            'null' => false,
            'default' => 1
        ]);
        $table2->addForeignKey('created_by', 'employees', 'id', [
            'constraint' => 'fk_suppliers_created_by'
        ]);
        $table2->addForeignKey('modified_by', 'employees', 'id', [
            'constraint' => 'fk_suppliers_modified_by'
        ]);
        $table2->update();

        $table3 = $this->table('purchases');
        $table3->addColumn('created_by', 'integer', [
            'limit' => 50,
            'null' => false,
            'default' => 1
        ]);
        $table3->addColumn('modified_by', 'integer', [
            'limit' => 50,
            'null' => false,
            'default' => 1
        ]);
        $table3->addForeignKey('created_by', 'employees', 'id', [
            'constraint' => 'fk_purchases_created_by'
        ]);
        $table3->addForeignKey('modified_by', 'employees', 'id', [
            'constraint' => 'fk_purchases_modified_by'
        ]);
        $table3->update();

        $table4 = $this->table('stocks');
        $table4->addColumn('created_by', 'integer', [
            'limit' => 50,
            'null' => false,
            'default' => 1
        ]);
        $table4->addColumn('modified_by', 'integer', [
            'limit' => 50,
            'null' => false,
            'default' => 1
        ]);
        $table4->addForeignKey('created_by', 'employees', 'id', [
            'constraint' => 'fk_stocks_created_by'
        ]);
        $table4->addForeignKey('modified_by', 'employees', 'id', [
            'constraint' => 'fk_stocks_modified_by'
        ]);
        $table4->update();

        $table5 = $this->table('purchase_transactions');
        // $table5->dropForeignKey('fk_purchase_transactions_employees');
        // $table5->removeColumn('employee_id');
        // Hapus manual saja dari database
        $table5->addColumn('created_by', 'integer', [
            'limit' => 50,
            'null' => false,
            'default' => 1
        ]);
        $table5->addColumn('modified_by', 'integer', [
            'limit' => 50,
            'null' => false,
            'default' => 1
        ]);
        $table5->addForeignKey('created_by', 'employees', 'id', [
            'constraint' => 'fk_purchase_transactions_created_by'
        ]);
        $table5->addForeignKey('modified_by', 'employees', 'id', [
            'constraint' => 'fk_purchase_transactions_modified_by'
        ]);
        $table5->update();

        $table6 = $this->table('sale_transactions');
        // $table6->dropForeignKey('fk_sale_transactions_employees');
        // $table6->removeColumn('employee_id');
        // Hapus manual saja dari database
        $table6->addColumn('created_by', 'integer', [
            'limit' => 50,
            'null' => false,
            'default' => 1
        ]);
        $table6->addColumn('modified_by', 'integer', [
            'limit' => 50,
            'null' => false,
            'default' => 1
        ]);
        $table6->addForeignKey('created_by', 'employees', 'id', [
            'constraint' => 'fk_sale_transactions_created_by'
        ]);
        $table6->addForeignKey('modified_by', 'employees', 'id', [
            'constraint' => 'fk_sale_transactions_modified_by'
        ]);
        $table6->update();

        $table7 = $this->table('purchase_payments');
        $table7->addColumn('created_by', 'integer', [
            'limit' => 50,
            'null' => false,
            'default' => 1
        ]);
        $table7->addColumn('modified_by', 'integer', [
            'limit' => 50,
            'null' => false,
            'default' => 1
        ]);
        $table7->addForeignKey('created_by', 'employees', 'id', [
            'constraint' => 'fk_purchase_payments_created_by'
        ]);
        $table7->addForeignKey('modified_by', 'employees', 'id', [
            'constraint' => 'fk_purchase_payments_modified_by'
        ]);
        $table7->update();

        $table8 = $this->table('sale_payments');
        $table8->addColumn('created_by', 'integer', [
            'limit' => 50,
            'null' => false,
            'default' => 1
        ]);
        $table8->addColumn('modified_by', 'integer', [
            'limit' => 50,
            'null' => false,
            'default' => 1
        ]);
        $table8->addForeignKey('created_by', 'employees', 'id', [
            'constraint' => 'fk_sale_payments_created_by'
        ]);
        $table8->addForeignKey('modified_by', 'employees', 'id', [
            'constraint' => 'fk_sale_payments_modified_by'
        ]);
        $table8->update();
    }
}