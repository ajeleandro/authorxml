<div class="videos form">
<?php echo $this->Form->create('Video'); ?>
	<fieldset>
		<legend><?php echo __('Add Video'); ?></legend>
        <button type="button" onclick="resetinputs('VideoAddForm')" class="clearinputs">Clear Inputs</button>
	<?php
        
        echo $this->Form->input('accesssite_id',
        array(
            'label' => 'Access Site'
        ));
        echo $this->Form->input('title');
        echo $this->Form->input('File Path', array('label' => array('text' => 'Find File Here')));
        echo $this->Form->input('File Name');

        echo '<h3 style="margin-top: 50px;">Contibutors</h3>';

        /*echo '<h4>Step 1: ADD Contributors to the list</h4>';
        echo '<div>'.$this->Html->link('Add new Contributor', 'javascript:', array(
            'onclick' => "var openWin = window.open('".$this->Html->url(array('controller'=>'Contributors', 'action'=>'quickadd'))."', '_blank', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=500,height=500');  reload(); return false;"
        )).'</div>';*/

        echo '<h4 style="margin-bottom: -5px;margin-top: 1.2em;">Step 1: Select AUTHOR(S) or  ';
        echo $this->Html->link('Add new Contributor', 'javascript:', array(
            'onclick' => "var openWin = window.open('".$this->Html->url(array('controller'=>'Contributors', 'action'=>'quickadd'))."', '_blank', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=500,height=500');  reload(); return false;"
        )).'</h4>';
        echo $this->Form->input('authors',
        array(
            'label' => '',
            'type' => 'select',
            'options' => $authors,
            'multiple' => 'multiple'
        ));
        echo '<p style="font-size: 11px;margin-left: 7px;margin-top: -19px;">note: You can have multiple selections by using the "ctrl" key. You can <a href="javascript:void(0)" onclick="location.reload(true);">Refresh List</a> or <a href="javascript:void(0)" onclick="unselect(\'#VideoAuthors\');">Unselect</a></p> ';
        echo '&nbsp';
        echo '<h4 style="margin-bottom: -5px; margin-top: 10px;">Step 2: Select MEDICAL EDITOR(S) or ';
        echo $this->Html->link('Add new Contributor', 'javascript:', array(
            'onclick' => "var openWin = window.open('".$this->Html->url(array('controller'=>'Contributors', 'action'=>'quickadd'))."', '_blank', 'toolbar=0,scrollbars=1,location=0,status=1,menubar=0,resizable=1,width=500,height=500');  reload(); return false;"
        )).'</h4>';
        echo $this->Form->input('editors',
        array(
            'label' => '',
            'type' => 'select',
            'options' => $editors,
            'multiple' => 'multiple'
        ));
        echo '<p style="font-size: 11px;margin-left: 7px;margin-top: -19px;">note: You can have multiple selections by using the "ctrl" key You can <a href="javascript:void(0)" onclick="location.reload(true);">Refresh List</a> or <a href="javascript:void(0)" onclick="unselect(\'#VideoEditors\');">Unselect</a></p> ';

        echo '<h3 style="margin-top: 50px;">Timing</h3>';
        
	echo $this->Form->input('duration', array('label' => array('text' => 'Video Total Run Time')));
        echo $this->Form->input('Chapters and Cue Frames', array('label' => array('text' => 'Cue points')));
        
        echo '<h3>Mapping</h3>';
        
	echo $this->Form->input('Book Source Line');

        echo '<div style="display: inline-flex;padding-left: 0;margin-bottom: 0;padding-bottom: 0;">';

        echo $this->Form->input('category_id', 
            array(
                'label' => 'Parent Category',
                'id' => 'ParentCategoryId',
                'type' => 'select',
                'required' => FALSE,
                'options' => $parentcategories,
                'empty' => array(NULL => '')
            ));

        echo '<div style="padding-top: 0;display: inherit;" id="categories">';

        echo $this->Form->input('category_id', 
            array(
                'label' => 'SubCategory',
                'id' => 'subcategory',
                'type' => 'select',
                'required' => FALSE,
                'empty' => array(NULL => '')
            ));
        //echo '</div><a id="refreshcategories" style="font-size: 11px;padding-top: 30px;" href="javascript:void(0)">Refresh List</a></div>';
        echo '</div></div>';
		echo $this->Form->input('Placement', array('label' => array('text' => 'Special placement on the site')));

        echo $this->Form->input('New Label', array(
            'type' => 'select',
            'label' => 'Use "new!" label? ',
            'options' => array(
                    '0' => 'No',
                    '1' => 'Yes'
            )
        ));

		echo $this->Form->input('Other Instructions');
         
        echo '<h3>Brightcove & Silverchair Info</h3>';

        echo $this->Form->input('videoid', array('label' => array('text' => 'Brightcove ID')));
		echo $this->Form->input('height');
		echo $this->Form->input('width');
		echo $this->Form->input('player');
		echo $this->Form->input('playerkey');
		echo $this->Form->input('Thumbnail');
        ?><p style="color: red;font-size: 11px;margin-left: 7px;margin-top: -19px;">(This will also be used for the XML file name)</p><?php
		echo $this->Form->input('Tags', array('placeholder' => 'Multiple Tags are separated by comas'));
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

<?php echo $this->element('fieldscache'); ?>
<?php echo $this->element('reloadonfocus'); ?>

<?php    
    $this->Js->get('#ParentCategoryId')->event('change', 
    $this->Js->request(array(
        'controller'=>'videos',
        'action'=>'getbycategory',
        ), array(
            'update'=>'#categories',
            'async' => true,
            'method' => 'post',
            'dataExpression'=>true,
            'data'=> $this->Js->serializeForm(array(
                'isForm' => true,
                'inline' => true
            ))
        ))
    );
     
?>
<script>
    /*$("#refreshcategories").bind("click", function (event) {
        $.ajax({
            async:true, data:$("#ParentCategoryId").serialize(), dataType:"html", success:function (data, textStatus) {
                $("#categories").html(data);}, type:"post", url:"\/videos\/getbycategory"});
    return false;});*/


    $("document").ready(function () {
                $.ajax({
            async:true, data:$("#ParentCategoryId").serialize(), dataType:"html", success:function (data, textStatus) {
                $("#categories").html(data);}, type:"post", url:"\/videos\/getbycategory"});
    });

</script>