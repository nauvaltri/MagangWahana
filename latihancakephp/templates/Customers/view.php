<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Customer'), ['action' => 'edit', $customer->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Customer'), ['action' => 'delete', $customer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $customer->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Customers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Customer'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="customers view content">
            <h3><?= h($customer->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($customer->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('NIK') ?></th>
                    <td><?= h($customer->nik) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($customer->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($customer->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($customer->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($customer->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($customer->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created By') ?></th>
                    <td>
                        <?= $customer->has('created_by_employee') ?
                            $this->Html->link($customer->created_by_employee->fullname, ['controller' => 'Employees', 'action' => 'view', $customer->created_by]) : '' ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Modified By') ?></th>
                    <td>
                        <?= $customer->has('modified_by_employee') ?
                            $this->Html->link($customer->modified_by_employee->fullname, ['controller' => 'Employees', 'action' => 'view', $customer->modified_by]) : '' ?>
                    </td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Address') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($customer->address)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Sale Transactions') ?></h4>
                <?php if (!empty($customer->sale_transactions)) : ?>
                    <div class="table-responsive">
                        <table>
                            <tr>
                                <th><?= __('Id') ?></th>
                                <th><?= __('Customer Id') ?></th>
                                <th><?= __('Stock Id') ?></th>
                                <th><?= __('Price') ?></th>
                                <th><?= __('Quantity') ?></th>
                                <th><?= __('Total Price') ?></th>
                                <th><?= __('Transaction Date') ?></th>
                                <th><?= __('Created') ?></th>
                                <th><?= __('Modified') ?></th>
                                <th><?= __('Created_By') ?></th>
                                <th><?= __('Modified_By') ?></th>
                                <th class="actions"><?= __('Actions') ?></th>
                            </tr>
                            <?php foreach ($customer->sale_transactions as $saleTransactions) : ?>
                                <tr>
                                    <td><?= h($saleTransactions->id) ?></td>
                                    <td><?= h($saleTransactions->customer_id) ?></td>
                                    <td><?= h($saleTransactions->stock_id) ?></td>
                                    <td><?= h($saleTransactions->price) ?></td>
                                    <td><?= h($saleTransactions->quantity) ?></td>
                                    <td><?= h($saleTransactions->total_price) ?></td>
                                    <td><?= h($saleTransactions->transaction_date) ?></td>
                                    <td><?= h($saleTransactions->created) ?></td>
                                    <td><?= h($saleTransactions->modified) ?></td>
                                    <td><?= h($saleTransactions->created_by) ?></td>
                                    <td><?= h($saleTransactions->modified_by) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['controller' => 'SaleTransactions', 'action' => 'view', $saleTransactions->id]) ?>
                                        <?= $this->Html->link(__('Edit'), ['controller' => 'SaleTransactions', 'action' => 'edit', $saleTransactions->id]) ?>
                                        <?= $this->Form->postLink(__('Delete'), ['controller' => 'SaleTransactions', 'action' => 'delete', $saleTransactions->id], ['confirm' => __('Are you sure you want to delete # {0}?', $saleTransactions->id)]) ?>
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