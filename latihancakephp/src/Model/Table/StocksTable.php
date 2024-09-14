<?php

declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Stocks Model
 *
 * @property \App\Model\Table\SaleTransactionsTable&\Cake\ORM\Association\HasMany $SaleTransactions
 *
 * @method \App\Model\Entity\Stock newEmptyEntity()
 * @method \App\Model\Entity\Stock newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Stock[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Stock get($primaryKey, $options = [])
 * @method \App\Model\Entity\Stock findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Stock patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Stock[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Stock|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Stock saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Stock[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Stock[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Stock[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Stock[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StocksTable extends Table
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

        $this->setTable('stocks');
        $this->setDisplayField('merk');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('SaleTransactions', [
            'foreignKey' => 'stock_id',
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
            ->scalar('merk')
            ->maxLength('merk', 50)
            ->requirePresence('merk', 'create')
            ->notEmptyString('merk');

        $validator
            ->scalar('model')
            ->maxLength('model', 50)
            ->requirePresence('model', 'create')
            ->notEmptyString('model');

        $validator
            ->scalar('engine_capacity')
            ->maxLength('engine_capacity', 20)
            ->requirePresence('engine_capacity', 'create')
            ->notEmptyString('engine_capacity');

        $validator
            ->scalar('color')
            ->maxLength('color', 50)
            ->requirePresence('color', 'create')
            ->notEmptyString('color');

        $validator
            ->scalar('production_year')
            ->maxLength('production_year', 20)
            ->requirePresence('production_year', 'create')
            ->notEmptyString('production_year');

        $validator
            ->integer('price')
            ->requirePresence('price', 'create')
            ->notEmptyString('price');

        $validator
            ->integer('quantity')
            ->requirePresence('quantity', 'create')
            ->notEmptyString('quantity');

        return $validator;
    }
}