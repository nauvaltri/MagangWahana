<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PurchasePayment $purchasePayment
 * @var \Cake\Collection\CollectionInterface|string[] $purchaseTransactions
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Purchase Payments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="purchasePayments form content">
            <?= $this->Form->create($purchasePayment) ?>
            <fieldset>
                <legend><?= __('Add Purchase Payment') ?></legend>
                <?php
                echo $this->Form->control('purchase_transaction_id', [
                    'options' => $purchaseTransactions, // Data dari controller
                    'empty' => 'Pilih Purchase Transaction',
                    'label' => 'Purchase Transaction',
                    'valueField' => 'id',  // Menggunakan 'id' sebagai value
                    'textField' => 'full_description'  // Menampilkan full description
                ]);
                echo $this->Form->control('nominal');
                echo $this->Form->control('payment_method', ['options' => ['Cash' => 'Cash', 'Credit Card' => 'Credit Card', 'Transfer Bank' => 'Transfer Bank', 'Installment-Cash' => 'Installment-Cash', 'Installment-Transfer Bank' => 'Installment-Transfer Bank ', 'Other' => 'Other']]);
                echo $this->Form->control('status', ['options' => ['Waiting' => 'Waiting', 'Checking' => 'Checking', 'Invalid' => 'Invalid', 'Completed' => 'Completed', 'Cancelled' => 'Cancelled']]);
                echo $this->Form->control('payment_date');
                echo $this->Form->control('proof');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>