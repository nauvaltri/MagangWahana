<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SaleTransaction $saleTransaction
 * @var string[]|\Cake\Collection\CollectionInterface $employees
 * @var string[]|\Cake\Collection\CollectionInterface $customers
 * @var string[]|\Cake\Collection\CollectionInterface $stocks
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $saleTransaction->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $saleTransaction->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Sale Transactions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="saleTransactions form content">
            <?= $this->Form->create($saleTransaction) ?>
            <fieldset>
                <legend><?= __('Edit Sale Transaction') ?></legend>
                <?php
                    echo $this->Form->control('employee_id', ['options' => $employees]);
                    echo $this->Form->control('customer_id', ['options' => $customers]);
                    echo $this->Form->control('stock_id', ['options' => $stocks]);
                    echo $this->Form->control('price');
                    echo $this->Form->control('quantity');
                    echo $this->Form->control('total_price');
                    echo $this->Form->control('transaction_date');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
