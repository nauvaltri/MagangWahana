<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateEmployeesTable extends AbstractMigration
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
        $table = $this->table('employees');
        $table->addColumn('username', 'string', ['limit' => 50, 'null' => false]);
        $table->addColumn('fullname', 'string', ['limit' => 255, 'null' => false]);
        $table->addColumn('role', 'string', ['limit' => 50, 'null' => false]);
        $table->addColumn('phone', 'string', ['limit' => 20, 'null' => false]);
        $table->addColumn('email', 'string', ['limit' => 100, 'null' => false]);
        $table->addColumn('address', 'text', ['null' => false]);
        $table->addColumn('password', 'string', ['limit' => 255, 'null' => false]);
        $table->addColumn('last_login', 'datetime', ['null' => false]);
        $table->addColumn('created', 'datetime', ['null' => false]);
        $table->addColumn('modified', 'datetime', ['null' => false]);
        $table->create();
    }
}
