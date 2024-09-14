<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\SaleTransaction> $saleTransactions
 */
?>
<div class="saleTransactions index content">
    <?= $this->Html->link(__('New Sale Transaction'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Sale Transactions') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('employee_id') ?></th>
                    <th><?= $this->Paginator->sort('customer_id') ?></th>
                    <th><?= $this->Paginator->sort('stock_id') ?></th>
                    <th><?= $this->Paginator->sort('price') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('total_price') ?></th>
                    <th><?= $this->Paginator->sort('transaction_date') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($saleTransactions as $saleTransaction): ?>
                <tr>
                    <td><?= $this->Number->format($saleTransaction->id) ?></td>
                    <td><?= $saleTransaction->has('employee') ? $this->Html->link($saleTransaction->employee->username, ['controller' => 'Employees', 'action' => 'view', $saleTransaction->employee->id]) : '' ?></td>
                    <td><?= $saleTransaction->has('customer') ? $this->Html->link($saleTransaction->customer->name, ['controller' => 'Customers', 'action' => 'view', $saleTransaction->customer->id]) : '' ?></td>
                    <td><?= $saleTransaction->has('stock') ? $this->Html->link($saleTransaction->stock->merk, ['controller' => 'Stocks', 'action' => 'view', $saleTransaction->stock->id]) : '' ?></td>
                    <td><?= $this->Number->format($saleTransaction->price) ?></td>
                    <td><?= $this->Number->format($saleTransaction->quantity) ?></td>
                    <td><?= $this->Number->format($saleTransaction->total_price) ?></td>
                    <td><?= h($saleTransaction->transaction_date) ?></td>
                    <td><?= h($saleTransaction->created) ?></td>
                    <td><?= h($saleTransaction->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $saleTransaction->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $saleTransaction->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $saleTransaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $saleTransaction->id)]) ?>
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
