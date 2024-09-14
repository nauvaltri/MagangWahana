<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SalePayment $salePayment
 * @var \Cake\Collection\CollectionInterface|string[] $saleTransactions
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Sale Payments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="salePayments form content">
            <?= $this->Form->create($salePayment) ?>
            <fieldset>
                <legend><?= __('Add Sale Payment') ?></legend>
                <?php
                    echo $this->Form->control('sale_transaction_id', ['options' => $saleTransactions]);
                    echo $this->Form->control('nominal');
                    echo $this->Form->control('payment_method');
                    echo $this->Form->control('status');
                    echo $this->Form->control('payment_date');
                    echo $this->Form->control('proof');
                    echo $this->Form->control('voucher');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
