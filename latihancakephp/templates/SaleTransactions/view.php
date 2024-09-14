<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\SaleTransaction $saleTransaction
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Sale Transaction'), ['action' => 'edit', $saleTransaction->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Sale Transaction'), ['action' => 'delete', $saleTransaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $saleTransaction->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Sale Transactions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Sale Transaction'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="saleTransactions view content">
            <h3><?= h($saleTransaction->id) ?></h3>
            <table>
            <?php
                // Load VoucherHelper
                $this->loadHelper('Voucher');
                ?>
                <tr>
                    <th><?= __('Voucher') ?></th>
                    <td><?= $this->Voucher->getVoucher($saleTransaction->total_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Employee') ?></th>
                    <td><?= $saleTransaction->has('employee') ? $this->Html->link($saleTransaction->employee->username, ['controller' => 'Employees', 'action' => 'view', $saleTransaction->employee->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer') ?></th>
                    <td><?= $saleTransaction->has('customer') ? $this->Html->link($saleTransaction->customer->name, ['controller' => 'Customers', 'action' => 'view', $saleTransaction->customer->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Stock') ?></th>
                    <td><?= $saleTransaction->has('stock') ? $this->Html->link($saleTransaction->stock->merk, ['controller' => 'Stocks', 'action' => 'view', $saleTransaction->stock->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($saleTransaction->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Price') ?></th>
                    <td><?= $this->Number->format($saleTransaction->price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($saleTransaction->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Price') ?></th>
                    <td><?= $this->Number->format($saleTransaction->total_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Transaction Date') ?></th>
                    <td><?= h($saleTransaction->transaction_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($saleTransaction->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($saleTransaction->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Sale Payments') ?></h4>
                <?php if (!empty($saleTransaction->sale_payments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Sale Transaction Id') ?></th>
                            <th><?= __('Nominal') ?></th>
                            <th><?= __('Payment Method') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('Payment Date') ?></th>
                            <th><?= __('Proof') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th><?= __('Voucher') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($saleTransaction->sale_payments as $salePayments) : ?>
                        <tr>
                            <td><?= h($salePayments->id) ?></td>
                            <td><?= h($salePayments->sale_transaction_id) ?></td>
                            <td><?= h($salePayments->nominal) ?></td>
                            <td><?= h($salePayments->payment_method) ?></td>
                            <td><?= h($salePayments->status) ?></td>
                            <td><?= h($salePayments->payment_date) ?></td>
                            <td><?= h($salePayments->proof) ?></td>
                            <td><?= h($salePayments->created) ?></td>
                            <td><?= h($salePayments->modified) ?></td>
                            <td><?= h($salePayments->voucher) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'SalePayments', 'action' => 'view', $salePayments->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'SalePayments', 'action' => 'edit', $salePayments->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'SalePayments', 'action' => 'delete', $salePayments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $salePayments->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
