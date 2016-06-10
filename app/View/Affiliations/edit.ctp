<div class="affiliations form">
<?php echo $this->Form->create('Affiliation'); ?>
	<fieldset>
		<legend><?php echo __('Edit Affiliation'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('Name');
		echo $this->Form->input('Contributor');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Affiliation.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('Affiliation.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Affiliations'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Contributors'), array('controller' => 'contributors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contributor'), array('controller' => 'contributors', 'action' => 'add')); ?> </li>
	</ul>
</div>
