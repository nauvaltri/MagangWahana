<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PurchaseTransactions Model
 *
 * @property \App\Model\Table\EmployeesTable&\Cake\ORM\Association\BelongsTo $Employees
 * @property \App\Model\Table\PurchasesTable&\Cake\ORM\Association\BelongsTo $Purchases
 * @property \App\Model\Table\PurchasePaymentsTable&\Cake\ORM\Association\HasMany $PurchasePayments
 *
 * @method \App\Model\Entity\PurchaseTransaction newEmptyEntity()
 * @method \App\Model\Entity\PurchaseTransaction newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseTransaction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseTransaction get($primaryKey, $options = [])
 * @method \App\Model\Entity\PurchaseTransaction findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PurchaseTransaction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseTransaction[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PurchaseTransaction|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PurchaseTransaction saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PurchaseTransaction[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PurchaseTransaction[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PurchaseTransaction[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PurchaseTransaction[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PurchaseTransactionsTable extends Table
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

        $this->setTable('purchase_transactions');
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
        $this->belongsTo('Purchases', [
            'foreignKey' => 'purchase_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('PurchasePayments', [
            'foreignKey' => 'purchase_transaction_id',
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
            ->integer('employee_id')
            ->notEmptyString('employee_id');

        $validator
            ->integer('purchase_id')
            ->notEmptyString('purchase_id');

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
            ->scalar('code')
            ->maxLength('code', 30)
            ->requirePresence('code', 'create')
            ->notEmptyString('code')
            ->add('code', 'unique', [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'Code must be unique.'
            ]);

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
        $rules->add($rules->existsIn('purchase_id', 'Purchases'), ['errorField' => 'purchase_id']);

        return $rules;
    }
}