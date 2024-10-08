<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\SalePayment> $salePayments
 */
?>
<div class="salePayments index content">
    <?= $this->Html->link(__('New Sale Payment'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Sale Payments') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('sale_transaction_id') ?></th>
                    <th><?= $this->Paginator->sort('nominal') ?></th>
                    <th><?= $this->Paginator->sort('payment_method') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('payment_date') ?></th>
                    <th><?= $this->Paginator->sort('proof') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th><?= $this->Paginator->sort('voucher') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($salePayments as $salePayment): ?>
                <tr>
                    <td><?= $this->Number->format($salePayment->id) ?></td>
                    <td><?= $salePayment->has('sale_transaction') ? $this->Html->link($salePayment->sale_transaction->id, ['controller' => 'SaleTransactions', 'action' => 'view', $salePayment->sale_transaction->id]) : '' ?></td>
                    <td><?= $this->Number->format($salePayment->nominal) ?></td>
                    <td><?= h($salePayment->payment_method) ?></td>
                    <td><?= h($salePayment->status) ?></td>
                    <td><?= h($salePayment->payment_date) ?></td>
                    <td><?= h($salePayment->proof) ?></td>
                    <td><?= h($salePayment->created) ?></td>
                    <td><?= h($salePayment->modified) ?></td>
                    <td><?= h($salePayment->voucher) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $salePayment->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $salePayment->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $salePayment->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salePayment->id)]) ?>
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
