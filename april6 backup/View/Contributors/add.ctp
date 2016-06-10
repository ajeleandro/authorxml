<div class="contributors form">
<?php echo $this->Form->create('Contributor'); ?>
	<fieldset>
		<legend><?php echo __('Add Contributor'); ?></legend>
	<?php
		echo $this->Form->input('Name');
        echo $this->Form->input('type', array(
            'type' => 'select',
            'label' => 'Contributor Type',
            'options' => array(
                    '0' => 'Author',
                    '1' => 'Medical Editor'
            )
        ));
        echo '<div>'.$this->Html->link('Add new Affiliation', 'javascript:;', array(
            'onclick' => "var openWin = window.open('".$this->Html->url(array('controller'=>'Affiliations', 'action'=>'quickadd'))."', '_blank', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=500,height=500');  return false;"
        )).'</div>';

		echo $this->Form->input('Affiliation', array('label' => array('text' => 'Affiliations (Select multiple Affiliations using the "ctrl" key)')));
		echo $this->Form->input('Degree', array('label' => array('text' => 'Degrees (Select multiple Degrees using the "ctrl" key)')));
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


<?php echo $this->element('reloadonfocus'); ?>