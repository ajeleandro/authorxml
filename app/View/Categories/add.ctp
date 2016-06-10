<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
        <?php echo $this->element('actions'); ?>
	</ul>
</div>
<div class="categories form">
<?php echo $this->Form->create('Category',array('style'=>'height: 320px','onsubmit' =>'return submitquestion();')); ?>
	<fieldset>
		<legend><?php echo __('Add Category'); ?></legend>
	    <label class="question">Select the type of Category you want to add:</label>

        <a class="question" href="JavaScript:void(0);" id="button_toplevel">Top Level Category</a>&nbsp;
        <a style="display: flex;" class="question" href="JavaScript:void(0);" id="button_subcategory">SubCategory</a>
        <h3 id="toplevel" style="display: none">Adding Top Level Category:</h3>
        <h3 id="subcategory" style="display: none">Adding SubCategory:</h3>
<?php
        echo $this->Form->input('category_id', 
        array(
            'label' => array('text' => 'Select the Parent Category of the SubCategory you want to add','style' => 'display:none','id'=>'labeltopcategory'),
            'type' => 'select',
            'style' =>'display: none',
            'required' => FALSE,
            'options' => $categories,
            'empty' => array(NULL => '')
        ));
        echo $this->Form->input('name', 
        array(
            'label' => array('text' => 'Category Name','style' => 'display:none','id'=>'labelcategoryname'),
            'style' =>'display: none',
            'autocomplete' => 'off'
        ));

	?>
	</fieldset>
<?php 
 
 //echo $this->Form->submit('Submit',array('style'=>'display:none','id'=>'submit'));
 
    echo $this->Form->submit('Create', 
        array(
            'onmousedown' => 
                'itsclicked = true;',
            'onkeydown' =>
                'itsclicked = true;',
            'style'=>'display:none',
            'id'=>'submit'
    ));
 
?>

</div>

<script>

    $('#button_toplevel').bind('click', function () {
        $('#toplevel').show();
        $('.question').hide();
        $('.question').hide();
        $('#CategoryName').show();
        $('#labelcategoryname').show();
        $('#labelcategoryname').html('Top Level Category Name');
        $('#submit').show();
    });
    $('#button_subcategory').bind('click', function () {
        $('#subcategory').show();
        $('.question').hide();
        $('#labeltopcategory').show();
        $('#CategoryCategoryId').show();
        $('#CategoryName').show();
        $('#labelcategoryname').show();
        $('#labelcategoryname').html('SubCategory Name');
        $('#submit').show();
    });

    var itsclicked = false;

    function submitquestion() {

        if (itsclicked) {
            var ddl = document.getElementById("CategoryCategoryId");
            var selectedValue = ddl.options[ddl.selectedIndex].value;
            if (selectedValue == '') {
                if (confirm('Warning:  \n\nIf no ‘Parent Category’ is chosen the Subcategory you entered WILL become a parent category.')) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

</script>










