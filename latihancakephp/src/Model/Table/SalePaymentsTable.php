<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SalePayments Model
 *
 * @property \App\Model\Table\SaleTransactionsTable&\Cake\ORM\Association\BelongsTo $SaleTransactions
 *
 * @method \App\Model\Entity\SalePayment newEmptyEntity()
 * @method \App\Model\Entity\SalePayment newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\SalePayment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SalePayment get($primaryKey, $options = [])
 * @method \App\Model\Entity\SalePayment findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\SalePayment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SalePayment[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SalePayment|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SalePayment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SalePayment[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SalePayment[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\SalePayment[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SalePayment[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SalePaymentsTable extends Table
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

        $this->setTable('sale_payments');
        $this->setDisplayField('payment_method');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('SaleTransactions', [
            'foreignKey' => 'sale_transaction_id',
            'joinType' => 'INNER',
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
            ->integer('sale_transaction_id')
            ->notEmptyString('sale_transaction_id');

        $validator
            ->integer('nominal')
            ->requirePresence('nominal', 'create')
            ->notEmptyString('nominal');

        $validator
            ->scalar('payment_method')
            ->maxLength('payment_method', 50)
            ->requirePresence('payment_method', 'create')
            ->notEmptyString('payment_method');

        $validator
            ->scalar('status')
            ->maxLength('status', 50)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->dateTime('payment_date')
            ->requirePresence('payment_date', 'create')
            ->notEmptyDateTime('payment_date');

        $validator
            ->scalar('proof')
            ->maxLength('proof', 255)
            ->requirePresence('proof', 'create')
            ->notEmptyString('proof');

        $validator
            ->scalar('voucher')
            ->maxLength('voucher', 30)
            ->requirePresence('voucher', 'create')
            ->notEmptyString('voucher');

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
        $rules->add($rules->existsIn('sale_transaction_id', 'SaleTransactions'), ['errorField' => 'sale_transaction_id']);

        return $rules;
    }
}
