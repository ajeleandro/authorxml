<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
        <?php echo $this->element('actions'); ?>
	</ul>
</div>
<div class="index">
<?php
    echo $this->Html->script('clipboard.min');
    echo $this->Form->create('Brightcovecsv');
    echo $this->Html->css('buttonfix');
?>
    <fieldset style="margin-bottom: 0;padding-bottom: 0;">
		<legend><?php echo __('Brightcove Javascript Fields Extaction'); ?></legend>

    <?php     
        echo '<div style="width: 40%;display: inline-block; margin-right: 5%;">';
        echo $this->Form->input('Brightcovecsv',array(
        'label' => 'Paste HTML code here',
        'type'=>'textarea',
        'style' => 'height: 92px;resize:none'
        ));
        echo $this->Form->input('duration', array(
        'label' => array('text'=>'Duration','style'=>'margin-right:1%;display: inline-block;'),
        'style'=>'width:50%;',
        'after' => '<label id="runtime" style="display: inline-block; margin-left: 1%;"></label>'
        ));
        ?>
       
        </div>
        <div style="width: 48%;display: inline-block;vertical-align: top;">
            <?php
            echo $this->Form->input('csvlist', array(
                'label' => 'CSV list',
                'multiple' => 'multiple',
                'type' => 'select',
                'style' => 'height: 100px;font-size: 10px;'
            ));
            ?>
            <!--<button id="copy" class="btn" data-clipboard-text="There was a problem copying" onclick="return false;">
                Copy the latest to Clipboard
            </button>-->
            <button class="btn">
                <a id="copy" class="copya" data-clipboard-text="There was a problem copying" href="JavaScript:void(0);">Copy the latest to Clipboard</a>
            </button>
            <!--<button id="copyall" style="float:right" class="btn" data-clipboard-text="" onclick="return false;">
                Copy all to Clipboard
            </button>-->
        </div>
    </fieldset>  
    <!--<iframe id="iframeId" style="width: 100%; height: 500px" src="http://dhtmlx.com/docs/products/dhtmlxSpreadsheet/sample.shtml"></iframe>-->
</div>
<?php 
 echo $this->Html->script('brightcovecopy'); 
 echo $this->Html->script('runtimeconversionbrightcovecsv'); 
 ?>
<script>
    new Clipboard('.copya');
</script>