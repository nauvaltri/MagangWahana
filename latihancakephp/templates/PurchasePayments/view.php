<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PurchasePayment $purchasePayment
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Purchase Payment'), ['action' => 'edit', $purchasePayment->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Purchase Payment'), ['action' => 'delete', $purchasePayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchasePayment->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Purchase Payments'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Purchase Payment'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="purchasePayments view content">
            <h3><?= h($purchasePayment->payment_method) ?></h3>
            <table>
                <tr>
                    <th><?= __('Purchase Transaction') ?></th>
                    <td><?= $purchasePayment->has('purchase_transaction') ? $this->Html->link($purchasePayment->purchase_transaction->code, ['controller' => 'PurchaseTransactions', 'action' => 'view', $purchasePayment->purchase_transaction->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Method') ?></th>
                    <td><?= h($purchasePayment->payment_method) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($purchasePayment->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Proof') ?></th>
                    <td><?= h($purchasePayment->proof) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($purchasePayment->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Nominal') ?></th>
                    <td><?= $this->Number->format($purchasePayment->nominal) ?></td>
                </tr>
                <tr>
                    <th><?= __('Payment Date') ?></th>
                    <td><?= h($purchasePayment->payment_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($purchasePayment->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($purchasePayment->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
