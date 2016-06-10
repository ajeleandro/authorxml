<?php

    echo $this->Form->create('Contributor',array('style' => 'width: 100%','onsubmit' => 'selectAllOptions(AffiliationAffiliation); return itsclicked;'));  ?>
	<fieldset style="margin: 0;padding: 0">
	<legend><?php echo __('Add New Contributor'); ?></legend>
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
        'empty' => array('' => NULL),
        'options' => array(
                '0' => 'Author',
                '1' => 'Medical Editor'
        )
    ));
    $addurl = '<a id="addaffhref" href="JavaScript: addaffiliation()" id="addtolist">Add<a>';
    echo '<div style="display:inline-block; width:46%;">';
    echo $this->Form->input('affiliations_autocomplete',array(
        'label' => array('text' => ('Search existing Affiliations -or- Enter a new one then click: '.$this->Html->link('ADD','JavaScript: addaffiliation()')),'style'=>'margin-top: 1em;'),
        'placeholder'=>'Type the Name of the affiliation here then select it or Add it',
        'style' => 'margin-bottom: 1%;' 
    ));       
    echo '<label id="loading" style="display:none">Loading, please wait...</label>';
    echo '</div>';

    echo '<div style="display:inline-block; width:46%;  padding-left:0; margin-bottom: 0; padding-bottom: 0;">';
    echo $this->Form->input('Affiliation',
    array(
        'label' => array('text' => 'List of Affiliations for this Contributor'),
        'type' => 'select',
        'multiple' => 'multiple',
        'options' => $SessionAffiliations,
        'style' => 'height: 94px;',
        'after' => '<div style="float:right;margin-bottom: 0;padding-bottom: 0;"><a href="JavaScript:void(0);" id="btn-up">Move Up</a>&nbsp;|&nbsp;<a href="JavaScript:void(0);" id="btn-down">Move Down</a>&nbsp;|&nbsp;<a style="color:#D12E2E" href="JavaScript:resetList();" id="resetlist">Clear List</a></div>'
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
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>

    $('#logout_button').hide();

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

    function resetList() {
        //$('#AffiliationAffiliation').find('option').remove().end();
        window.location = "\/Contributors\/quickadd\/reset";
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