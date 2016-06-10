<div class="affiliations form">
<?php echo $this->Form->create('Affiliation'); ?>
	<fieldset>
		<legend><?php echo __('Add Affiliation'); ?></legend>
	<?php
		echo $this->Form->input('Name');
		echo $this->Form->input('Contributor');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Affiliations'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Contributors'), array('controller' => 'contributors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contributor'), array('controller' => 'contributors', 'action' => 'add')); ?> </li>
	</ul>
</div>
