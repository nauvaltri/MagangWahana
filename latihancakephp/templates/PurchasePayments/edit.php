<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PurchasePayment $purchasePayment
 * @var string[]|\Cake\Collection\CollectionInterface $purchaseTransactions
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $purchasePayment->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $purchasePayment->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Purchase Payments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="purchasePayments form content">
            <?= $this->Form->create($purchasePayment) ?>
            <fieldset>
                <legend><?= __('Edit Purchase Payment') ?></legend>
                <?php
                    echo $this->Form->control('purchase_transaction_id', ['options' => $purchaseTransactions]);
                    echo $this->Form->control('nominal');
                    echo $this->Form->control('payment_method');
                    echo $this->Form->control('status');
                    echo $this->Form->control('payment_date');
                    echo $this->Form->control('proof');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
