<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PurchaseTransaction $purchaseTransaction
 * @var \Cake\Collection\CollectionInterface|string[] $employees
 * @var \Cake\Collection\CollectionInterface|string[] $purchases
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Purchase Transactions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="purchaseTransactions form content">
            <?= $this->Form->create($purchaseTransaction) ?>
            <fieldset>
                <legend><?= __('Add Purchase Transaction') ?></legend>
                <?php
                echo $this->Form->control('purchase_id', [
                    'options' => $purchases, // Data dari controller
                    'empty' => 'Pilih Purchase',
                    'label' => 'Purchase',
                    'valueField' => 'id',  // Menggunakan 'id' sebagai value
                    'textField' => 'full_description'  // Menampilkan full description
                ]);
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