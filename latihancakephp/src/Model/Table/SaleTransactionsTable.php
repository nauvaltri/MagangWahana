<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SaleTransactions Model
 *
 * @property \App\Model\Table\EmployeesTable&\Cake\ORM\Association\BelongsTo $Employees
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\StocksTable&\Cake\ORM\Association\BelongsTo $Stocks
 *
 * @method \App\Model\Entity\SaleTransaction newEmptyEntity()
 * @method \App\Model\Entity\SaleTransaction newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\SaleTransaction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SaleTransaction get($primaryKey, $options = [])
 * @method \App\Model\Entity\SaleTransaction findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\SaleTransaction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SaleTransaction[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SaleTransaction|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SaleTransaction saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SaleTransaction[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SaleTransaction[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\SaleTransaction[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SaleTransaction[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SaleTransactionsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('sale_transactions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Employees', [
            'foreignKey' => 'created_by',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Employees', [
            'foreignKey' => 'modified_by',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Stocks', [
            'foreignKey' => 'stock_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('SalePayments', [
            'foreignKey' => 'sale_transaction_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('customer_id')
            ->notEmptyString('customer_id');

        $validator
            ->integer('stock_id')
            ->notEmptyString('stock_id');

        $validator
            ->integer('price')
            ->requirePresence('price', 'create')
            ->notEmptyString('price');

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmptyString('quantity');

        $validator
            ->integer('total_price')
            ->requirePresence('total_price', 'create')
            ->notEmptyString('total_price');

        $validator
            ->dateTime('transaction_date')
            ->requirePresence('transaction_date', 'create')
            ->notEmptyDateTime('transaction_date');

        $validator
            ->integer('created_by')
            ->notEmptyString('created_by');

        $validator
            ->integer('modified_by')
            ->notEmptyString('modified_by');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('created_by', 'Employees'), ['errorField' => 'created_by']);
        $rules->add($rules->existsIn('modified_by', 'Employees'), ['errorField' => 'modified_by']);
        $rules->add($rules->existsIn('customer_id', 'Customers'), ['errorField' => 'customer_id']);
        $rules->add($rules->existsIn('stock_id', 'Stocks'), ['errorField' => 'stock_id']);

        return $rules;
    }
}