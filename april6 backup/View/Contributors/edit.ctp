<div class="contributors form">
<?php echo $this->Form->create('Contributor'); ?>
	<fieldset>
		<legend><?php echo __('Edit Contributor'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('Name');
		echo $this->Form->input('type');
		echo $this->Form->input('Affiliation');
		echo $this->Form->input('Degree');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
        <?php echo $this->element('actions'); ?>
	</ul>
</div>
