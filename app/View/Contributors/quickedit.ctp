<?php
    $contributor = $this->request->data;

    echo $this->Form->create('Contributor',array('style' => 'width: 100%','onsubmit' => 'selectAllOptions(AffiliationAffiliation); return itsclicked;'));  ?>
	<fieldset style="margin: 0;padding: 0">
	<legend><?php echo __('Edit Contributor'); ?></legend>
	<?php
	echo '<div style="display:inline-block;padding: 0;margin: 0;">';
	echo $this->Form->input('Name',array('autocomplete' => 'off'));	
	echo '</div>';
	echo '<div style="display:inline-block;padding: 0;margin: 0;">';
    echo $this->Form->input('Surname',array('autocomplete' => 'off'));
    echo '</div>';
    echo '<div style="display:inline-block;padding: 0;margin: 0;">';
    echo $this->Form->input('Degrees',array('autocomplete' => 'off'));
    echo '</div>';
    echo $this->Form->input('type', array(
        'type' => 'select',
        'label' => 'Contributor Type',
        'options' => array(
                '0' => 'Author',
                '1' => 'Medical Editor'
        )
    ));

    echo '<div style="display:inline-block; width:46%;">';
    echo $this->Form->input('affiliations_autocomplete',array(
        'label' => array('text'=>'Search previously created Affiliations or Type a new one and click Add to the List','style'=>'margin-top: 1em;'),
        'placeholder'=>'Type the Name of the affiliation here then select it or Add it',
        'style' => 'margin-bottom: 1%;' ,
        'after'=> '<a id="addaffhref" href="JavaScript: addaffiliation();" id="addtolist">Create this new affiliation</a>'
    ));       
    echo '<label id="loading" style="display:none">Loading, please wait...</label>';
    echo '</div>';

    echo '<div style="display:inline-block; width:46%;  padding-left:0; margin-bottom: 0; padding-bottom: 0;">';

    $selectaffiliations = NULL;
    if(isset($objaffiliations)){
        $selectaffiliations = $objaffiliations;         
    }
    if(isset($SessionAffiliations)){
        $selectaffiliations = $selectaffiliations + $SessionAffiliations;         
    }
    
    echo $this->Form->input('Affiliation',
    array(
        'label' => 'List of Affiliations for this Contributor',
        'type' => 'select',
        'multiple' => 'multiple',
        'options' => $selectaffiliations,
        'style' => 'height: 94px;',
        'after' => '<label style="font-size: 90%;">To change the order delete the list, Save the changes and then add them in order</label><div style="float:right"><a href="JavaScript:location.reload(true);">Refresh</a>&nbsp;|&nbsp;<a style="color:#D12E2E" href="JavaScript:deleteSelected();" >Delete Selected</a></div>'
    ));
    echo '</div>';
    ?>
	</fieldset>
<style>.submit{margin-top: 0 !important;padding-bottom: 0 !important;}</style>
<?php 
    echo $this->Form->submit('Submit', 
        array(
            'onmousedown' => 
                'itsclicked = true; return true;',
            'onkeydown' =>
                'itsclicked = true; return true;'
        ));

    echo $this->Html->script('reloadonfocus');
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>

    $('#ContributorName').on('input paste', function () {
        if ($(this).val().indexOf(",") >= 0) {
            $(this).val($(this).val().replace(",", ""));
            alert("Name and Surname does not require commas ( , )");
        }
    });

    $('#ContributorSurname').on('input paste', function () {
        if ($(this).val().indexOf(",") >= 0) {
            $(this).val($(this).val().replace(",", ""));
            alert("Name and Surname does not require commas ( , )");
        }
    });

    $("document").ready(function () {
        $("#ContributorAffiliationsAutocomplete").val('');
        $('#ContributorName').val($('#ContributorName').val().replace(",", ""));
        $('#ContributorSurname').val($('#ContributorSurname').val().replace(",", ""));
    });

    var itsclicked = false;
    var availableTags = <?php echo $affiliations; ?>;
    $("#ContributorAffiliationsAutocomplete").autocomplete({
        source: availableTags,
        //minLength: 2, //This is the min ammount of chars before autocomplete kicks in
        autoFocus: false,
        select: function (event, ui) {
            $('#AffiliationAffiliation').append($('<option>', {
                value: ui.item.id,
                text: ui.item.value
            }));
            $('#ContributorAffiliationsAutocomplete').val("");
            return false; //without this return false; the .val("") wont work
        }
    });

    function selectAllOptions(obj) {
        for (var i = 0; i < obj.options.length; i++) {
            obj.options[i].selected = true;
        }
    }

    function deleteSelected(){
        $('#AffiliationAffiliation option:selected').remove();
    }

    $('#btn-up').bind('click', function () {
        $('#AffiliationAffiliation option:selected').each(function () {
            var newPos = $('#AffiliationAffiliation option').index(this) - 1;
            if (newPos > -1) {
                $('#AffiliationAffiliation option').eq(newPos).before("<option value='" + $(this).val() + "' selected='selected'>" + $(this).text() + "</option>");
                $(this).remove();
            }
        });
    });
    $('#btn-down').bind('click', function () {
        var countOptions = $('#AffiliationAffiliation option').size();
        $('#AffiliationAffiliation option:selected').each(function () {
            var newPos = $('#AffiliationAffiliation option').index(this) + 1;
            if (newPos < countOptions) {
                $('#AffiliationAffiliation option').eq(newPos).after("<option value='" + $(this).val() + "' selected='selected'>" + $(this).text() + "</option>");
                $(this).remove();
            }
        });
    });

    function addaffiliation() {
        var aff = $('#ContributorAffiliationsAutocomplete').val();
        $('#addaffhref').hide();
        $('#ContributorAffiliationsAutocomplete').hide();
        $('#loading').show();
        $.ajax({
            async: true,
            data: {"Affiliation":{"Name":aff}},
            dataType: "html",
            success: function (data, textStatus) {
                var affiliation = JSON.parse(data);
                $('#AffiliationAffiliation').append($('<option>', {
                    value: affiliation['id'],
                    text: affiliation['Name']
                }));
                $('#loading').hide();
                $('#addaffhref').show();
                $('#ContributorAffiliationsAutocomplete').show();
            },
            type: "post",
            url: "\/affiliations\/addajax"
        });
    }

</script>