<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
        <?php echo $this->element('actions'); ?>
	</ul>
</div>
<div class="accesssites form">

    <?php echo $this->Form->create('Accesssite'); ?>
	    <fieldset>
		    <legend><?php echo __('Add Access Site'); ?></legend>
	    <?php
		    echo $this->Form->input('name',array('autocomplete' => 'off'));
	    ?>
	    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>

