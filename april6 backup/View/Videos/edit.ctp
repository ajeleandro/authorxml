<div class="videos form">
<?php echo $this->Form->create('Video'); ?>
	<fieldset>
		<legend><?php echo __('Edit Video'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('videoid');
		echo $this->Form->input('title');
		echo $this->Form->input('duration');
		echo $this->Form->input('height');
		echo $this->Form->input('width');
		echo $this->Form->input('player');
		echo $this->Form->input('playerkey');
		echo $this->Form->input('category_id');
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
