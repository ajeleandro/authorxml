<div class="users form">
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend>
            <?php echo __('Please enter your username and password'); ?>
        </legend>
        <?php echo $this->Form->input('username',array('style'=>'width: 20%;'));
        echo $this->Form->input('password',array('style'=>'width: 20%;'));
    ?>
    </fieldset>
<?php echo $this->Form->end(__('Login')); ?>
</div>