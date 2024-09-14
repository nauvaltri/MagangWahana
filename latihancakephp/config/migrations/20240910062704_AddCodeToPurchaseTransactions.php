<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class AddCodeToPurchaseTransactions extends AbstractMigration
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
        $table = $this->table('purchase_transactions');
        $table->addColumn('code', 'string', [
            'limit' => 30,
            'null' => false,
        ]);
        // Tambahkan index unik pada kolom 'code'
        $table->addIndex(['code'], ['unique' => true, 'name' => 'idx_unique_code']);

        $table->update();

        // Akan muncul pesan error
        // PDOException: SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry '' for key 'idx_unique_code'
        // in C:\xampp\htdocs\first_cakephp\vendor\robmorgan\phinx\src\Phinx\Db\Adapter\PdoAdapter.php:192
        // Stack trace:

        // Setelah itu tambahkan data di kolom kode sacara manual.
    }
}
