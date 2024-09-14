<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee $employee
 */
?>
<div class="row justify-content-center">
    <div class="column-responsive column-100">
        <div class="employees form content">
            <?= $this->Form->create(null, ['url' => ['controller' => 'Employees', 'action' => 'login']]) ?>
            <fieldset>
                <legend><?= __('Login Employee') ?></legend>
                <!-- Kontrol untuk input username atau email -->
                <?= $this->Form->control('username', [
                    'label' => 'Username or Email',
                    'class' => 'form-control'
                ]) ?>
                <!-- Kontrol untuk input password -->
                <?= $this->Form->control('password', [
                    'label' => 'Password',
                    'class' => 'form-control'
                ]) ?>
            </fieldset>
            <?= $this->Form->button(__('Login')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>