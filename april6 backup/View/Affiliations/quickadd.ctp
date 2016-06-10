
<?php echo $this->Form->create('Affiliation'); ?>
	<fieldset>
		<legend><?php echo __('Add Affiliation'); ?></legend>
	<?php
		echo $this->Form->input('Name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>



