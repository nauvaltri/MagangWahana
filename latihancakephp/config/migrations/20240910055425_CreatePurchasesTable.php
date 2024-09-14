<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreatePurchasesTable extends AbstractMigration
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
        $table = $this->table('purchases');
        $table->addColumn('supplier_id', 'integer', ['null' => false]);
        $table->addForeignKey('supplier_id', 'suppliers', 'id', [
            'constraint' => 'fk_purchases_suppliers'
        ]);
        $table->addColumn('merk', 'string', ['limit' => 50, 'null' => false]);
        $table->addColumn('model', 'string', ['limit' => 50, 'null' => false]);
        $table->addColumn('engine_capacity', 'string', ['limit' => 20, 'null' => false]);
        $table->addColumn('color', 'string', ['limit' => 50, 'null' => false]);
        $table->addColumn('production_year', 'string', ['limit' => 20, 'null' => false]);
        $table->addColumn('price', 'integer', ['null' => false]);
        $table->addColumn('created', 'datetime', ['null' => false]);
        $table->addColumn('modified', 'datetime', ['null' => false]);
        $table->create();
    }
}
