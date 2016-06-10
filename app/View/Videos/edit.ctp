<?php
$video = $this->request->data;
echo $this->Html->css('buttonfix');
?>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
        <?php echo $this->element('actions'); ?>
	</ul>
</div>
<div class="videos form">
<?php echo $this->Form->create('Video',array('onsubmit' => 'selectAllOptions(ContributorContributor); return itsclicked;'));  ?>
	<fieldset>
		<legend><?php echo __('Edit Video'); ?></legend>
        <button type="button" onclick="resetinputs('VideoAddForm')" class="clearinputs">Clear Inputs</button>
        <label style="float: right;margin-bottom: -2%;">Fields with <b style="color: #e32; font-weight: 100">*</b> are required</label>
	<?php
        echo $this->Form->input('id');
        echo $this->Form->input('accesssite_id',
        array(
            'label' => 'Site',
            'empty' => array(NULL => '')
        ));
        echo $this->Form->input('title',array('autocomplete' => 'off'));
        echo $this->Form->input('File Path', array('label' => 'Find File Here','autocomplete' => 'off'));
        echo $this->Form->input('File Name', array('label' => 'Video asset file name','autocomplete' => 'off'));
        
        echo '<h3 style="margin-top: 50px;">Contributors</h3>';
        echo '<div style="display:inline-block; width:46%; padding-left:0">';

        echo $this->Form->input('contributors_autocomplete',array(
            'label' => array('text'=>'Search existing contributors:','style'=>'margin-top: 1em;'),
            'placeholder'=>'Type the Name or Surname here then select it'
        ));       

        echo $this->Html->link('Or Create a New Contributor', 'javascript:', array(
            'style'=>'padding:.5em',
            'onclick' => "PopupCenter('".$this->Html->url(array('controller'=>'Contributors', 'action'=>'quickadd'))."','Add New Contributor',1000,500); reload(); return false;"
        ));
       

        echo '</div>';
        $selectcontributors = NULL;
        if(isset($objcontributors)){
            $selectcontributors = $objcontributors;
        }
        if(isset($SessionContributors)){
            if(isset($selectcontributors))
                $selectcontributors = $selectcontributors + $SessionContributors;  
            else
                $selectcontributors = $SessionContributors;
        }
       
        echo '<div style="display:inline-block; width:46%">';
        echo $this->Form->input('Contributor',
        array(
            'label' => array('text' => '(Double-Click to <b>EDIT</b> Contributor)','style' => 'font-size:90%'),
            'type' => 'select',
            'multiple' => 'multiple',
            'options' => $selectcontributors,
            'style' => 'height: 94px;',
            'after' => '<label style="font-size: 90%;">To change the list order: First, delete all, then add them back in the correct order.</label><div style="float:right"><a href="JavaScript:location.reload(true);">Refresh</a>&nbsp;|&nbsp;<a style="color:#D12E2E" href="JavaScript:deleteSelected();" >Delete one Selected</a></div>'

        ));

        echo '</div>';
        echo '<h3>Timing</h3>';

	    echo $this->Form->input('duration', array('label' => 'Video Total Run Time','autocomplete' => 'off'));
        echo $this->Form->input('Chapters and Cue Frames', array('label' => 'Cue points','autocomplete' => 'off'));
        
        echo '<h3>Mapping</h3>';
        
	    echo $this->Form->input('Book Source Line',array('autocomplete' => 'off'));
	    echo $this->Form->input('Book Mapping',array('autocomplete' => 'off'));

        echo '<div id="parentcategory" style="display: inline-flex;padding-left: 0;margin-bottom: 0;padding-bottom: 0;">';

        echo $this->Form->input('category_id', 
            array(
                'label' => 'Top Level Category',
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

		echo $this->Form->input('Other Instructions',array('autocomplete' => 'off'));
         
        echo '<h3>Brightcove & Silverchair Info</h3>';

        echo $this->Form->input('Brightcovecsv',array(
            'label' => 'Brightcove Javascript Fields Extaction',
            'style' => 'width:33%;height: 23px;',
            'type'=>'textarea',
            'placeholder' => 'Paste the HTML code here'
        ));

        echo $this->Form->input('videoid', array('label' => 'Brightcove ID','autocomplete' => 'off'));
		echo $this->Form->input('width',array('autocomplete' => 'off'));
		echo $this->Form->input('height',array('autocomplete' => 'off'));
		echo $this->Form->input('player', array('label' => 'Player ID','autocomplete' => 'off'));
		echo $this->Form->input('playerkey',array('autocomplete' => 'off'));
		echo $this->Form->input('Thumbnail',array('autocomplete' => 'off'));
        ?><p style="color: red;font-size: 11px;margin-left: 7px;margin-top: -19px;">(This will also be used for the XML file name)</p><?php
		echo $this->Form->input('Tags', array('placeholder' => 'Multiple Tags are separated by comas'));
	?>
	</fieldset>
    <?php 
    echo $this->Form->submit('Save', 
        array(
            'onmousedown' => 
                'itsclicked = true; return true;',
            'onkeydown' =>
                'itsclicked = true; return true;'
        ));
    ?>
</div>
<script>
    window.categoryload = 1;
</script>
<?php 
    //echo $this->Html->script('fieldscache');
    echo $this->Html->script('reloadonfocus');  
    echo $this->Html->script('brightcovecopy');
    echo $this->Html->script('runtimeconversion');
    
    $this->Js->get('#ParentCategoryId')->event('change',
    $this->Js->request(array(
        'controller'=>'videos',
        'action'=>'getbycategory/'.$video['Category']['id'],
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
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>

    function deletecontrib(contribid) {
        $.ajax({
            async: true, 
            dataType: "html",
            type: "post",
            url: "\/videos\/deletecontrib\/" + contribid + "\/" + "<?php echo $video['Video']['id']; ?>"
        });
        alert('Contributor Deleted');
    }

    $("document").ready(function () {

        $("#VideoContributorsAutocomplete").val('');

        $("#parentcategory select").val("<?php echo $video['Category']['category_id']; ?>");
        $.ajax({
            async: true, 
            data: $("#ParentCategoryId").serialize(), 
            dataType: "html", 
            success: function (data, textStatus) {
                $("#categories").html(data);
            }, 
            type: "post", 
            url: "\/videos\/getbycategory\/<?php echo $video['Category']['id']; ?>"
        });
    });
    var itsclicked = false;
    var availableTags =  <?php echo $contributors; ?>;


    $('#ContributorContributor').on('dblclick', function() {
        var value = $(this).val();
        PopupCenter('/contributors/quickedit/' + value,'Edit Contributor',1000,500);
        reload(); 
        return false;
    });


    $("#VideoContributorsAutocomplete").autocomplete({
        source: availableTags,
        //minLength: 2, //This is the min ammount of chars before autocomplete kicks in
        autoFocus: true,
        select: function (event, ui) {
            $('#ContributorContributor').append($('<option>', {
                value: ui.item.id,
                text:  ui.item.value
            }));
            $('#VideoContributorsAutocomplete').val("");
            $.ajax({
                async: true, 
                dataType: "html",
                type: "post",
                url: "\/videos\/addseassioncontrib\/" + ui.item.id + "\/" + ui.item.value
            });
            return false; //without this return false; the .val("") wont work
        }
    });

    function selectAllOptions(obj) {
        for (var i=0; i<obj.options.length; i++) {
            obj.options[i].selected = true;
        }
    }

    function deleteSelected(){
        deletecontrib($('#ContributorContributor option:selected').val());
        $('#ContributorContributor option:selected').remove();
    }

    $('#btn-up').bind('click', function() {
        $('#ContributorContributor option:selected').each( function() {
            var newPos = $('#ContributorContributor option').index(this) - 1;
            if (newPos > -1) {
                $('#ContributorContributor option').eq(newPos).before("<option value='"+$(this).val()+"' selected='selected'>"+$(this).text()+"</option>");
                $(this).remove();
            }
        });
    });
    $('#btn-down').bind('click', function() {
        var countOptions = $('#ContributorContributor option').size();
        $('#ContributorContributor option:selected').each( function() {
            var newPos = $('#ContributorContributor option').index(this) + 1;
            if (newPos < countOptions) {
                $('#ContributorContributor option').eq(newPos).after("<option value='"+$(this).val()+"' selected='selected'>"+$(this).text()+"</option>");
                $(this).remove();
            }
        });
    });

    function PopupCenter(url, title, w, h) {
        // Fixes dual-screen position                         Most browsers      Firefox
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

        var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

        // Puts focus on the newWindow
        if (window.focus) {
            newWindow.focus();
        }
    }

</script>