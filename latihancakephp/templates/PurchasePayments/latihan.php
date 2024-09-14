<?php

/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\PurchasePayment> $purchasePayments
 */
?>
<div class="purchasePayments index content">
    <?= $this->Html->link(__('New Purchase Payment'), ['action' => 'add'], ['class' => 'button float-right']) ?>

    <!-- Form untuk filter tanggal start dan end -->
    <?= $this->Form->create(null, ['type' => 'get']) ?>
    <fieldset>
        <legend><?= __('Filter by Date') ?></legend>
        <div>
            <?= $this->Form->control('start_date', [
                'type' => 'date',
                'label' => 'Start Date',
                'value' => $this->request->getQuery('start_date')
            ]) ?>
            <?= $this->Form->control('end_date', [
                'type' => 'date',
                'label' => 'End Date',
                'value' => $this->request->getQuery('end_date')
            ]) ?>
        </div>
    </fieldset>
    <?= $this->Form->button(__('Filter')) ?>
    <?= $this->Form->end() ?>

    <!-- Tampilkan rentang waktu jika ada filter -->
    <?php if (!empty($startDate) && !empty($endDate)): ?>
        <p style="margin-top: 20px;">Menampilkan data dari <?= h($startDate) ?> hingga <?= h($endDate) ?></p>
    <?php endif; ?>

    <h3><?= __('Purchase Payments') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('purchase_transaction_id') ?></th>
                    <th><?= $this->Paginator->sort('nominal') ?></th>
                    <th><?= $this->Paginator->sort('payment_method') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('payment_date') ?></th>
                    <th><?= $this->Paginator->sort('proof') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($purchasePayments as $purchasePayment): ?>
                    <tr>
                        <td><?= $this->Number->format($purchasePayment->id) ?></td>
                        <td><?= $purchasePayment->has('purchase_transaction') ? $this->Html->link($purchasePayment->purchase_transaction->id, ['controller' => 'PurchaseTransactions', 'action' => 'view', $purchasePayment->purchase_transaction->id]) : '' ?></td>
                        <td><?= $this->Number->format($purchasePayment->nominal) ?></td>
                        <td><?= h($purchasePayment->payment_method) ?></td>
                        <td><?= h($purchasePayment->status) ?></td>
                        <td><?= h($purchasePayment->payment_date) ?></td>
                        <td><?= h($purchasePayment->proof) ?></td>
                        <td><?= h($purchasePayment->created) ?></td>
                        <td><?= h($purchasePayment->modified) ?></td>
                        <td class="actions">
                            <?= $this->Html->link(__('View'), ['action' => 'view', $purchasePayment->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $purchasePayment->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $purchasePayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $purchasePayment->id)]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>