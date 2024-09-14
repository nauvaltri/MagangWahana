<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PurchasePayments Model
 *
 * @property \App\Model\Table\PurchaseTransactionsTable&\Cake\ORM\Association\BelongsTo $PurchaseTransactions
 *
 * @method \App\Model\Entity\PurchasePayment newEmptyEntity()
 * @method \App\Model\Entity\PurchasePayment newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PurchasePayment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PurchasePayment get($primaryKey, $options = [])
 * @method \App\Model\Entity\PurchasePayment findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PurchasePayment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PurchasePayment[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PurchasePayment|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PurchasePayment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PurchasePayment[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PurchasePayment[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PurchasePayment[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PurchasePayment[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PurchasePaymentsTable extends Table
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

        $this->setTable('purchase_payments');
        $this->setDisplayField('payment_method');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('PurchaseTransactions', [
            'foreignKey' => 'purchase_transaction_id',
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
            ->integer('purchase_transaction_id')
            ->notEmptyString('purchase_transaction_id');

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
        $rules->add($rules->existsIn('purchase_transaction_id', 'PurchaseTransactions'), ['errorField' => 'purchase_transaction_id']);

        return $rules;
    }
}
