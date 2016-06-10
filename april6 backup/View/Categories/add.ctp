<div class="categories form">
<?php echo $this->Form->create('Category'); ?>
	<fieldset>
		<legend><?php echo __('Add Category'); ?></legend>
	<?php
        echo $this->Form->input('category_id', 
        array(
            'label' => 'Parent Category (if needed)',
            'type' => 'select',
            'required' => FALSE,
            'options' => $categories,
            'empty' => array(NULL => '')
        ));
        echo $this->Form->input('name', 
        array(
            'label' => 'Category'
        ));

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
