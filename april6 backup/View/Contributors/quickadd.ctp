<?php echo $this->Form->create('Contributor'); ?>
	<fieldset>
	<legend><?php echo __('Add New Contributor'); ?></legend>
	<?php
	echo '<div style="display:inline-block;padding: 0;margin: 0;">';
	echo $this->Form->input('Name');	
	echo '</div>';
	echo '<div style="display:inline-block;padding: 0;margin: 0;">';
    echo $this->Form->input('Surname');
    echo '</div>';
    echo '<div style="display:inline-block;padding: 0;margin: 0;">';
    echo $this->Form->input('Degrees');
    echo '</div>';
    echo $this->Form->input('type', array(
        'type' => 'select',
        'label' => 'Contributor Type',
        'options' => array(
                '0' => 'Author',
                '1' => 'Medical Editor'
        )
    ));
    echo '<h4>Step 1: ADD Affiliations to the list</h4>';
    echo '<div>'.$this->Html->link('Add new Affiliation', 'javascript:;', array(
        'onclick' => "var openWin = window.open('".$this->Html->url(array('controller'=>'Affiliations', 'action'=>'quickadd'))."', '_blank', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=500,height=500'); reload(); return false;"
    )).'</div>';

    echo '<h4>Step 2: SELECT all the Doctor\'s Affiliations from the list</h4>';
	echo $this->Form->input('Affiliation', array('label' => array('text' => '')));
    echo '<p style="font-size: 11px;margin-left: 7px;margin-top: -19px;"><a href="javascript:void(0)" onclick="location.reload(true);">Refresh Lists</a> - <a href="javascript:void(0)" onclick="unselect(\'#AffiliationAffiliation\');unselect(\'#DegreeDegree\');">Unselect Lists</a></p>';
		
    ?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>

<?php echo $this->element('reloadonfocus'); ?>
<?php echo $this->element('fieldscache'); ?>