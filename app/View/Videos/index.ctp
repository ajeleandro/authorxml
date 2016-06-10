<?php
    $deletefirstrow = TRUE;
?>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<?php echo $this->element('actions'); ?>
	</ul>
</div>
<div class="videos index">
    <?php 
        if(isset($this->params['pass'][0])){
            if($this->params['pass'][0] == 0){
                echo '<h2>List of all Video Records not inside a project</h2>';
            }elseif(isset($videos[0]['Dir']['name'])){ 
                echo '<h2>List of Video Records in the <b>'.$videos[0]['Dir']['name'].'</b> Folder</h2>';
            }
        }else{
            echo '<h2>List of all Video Records in Database</h2>';
        }
     ?>
    
        <div class="filters">
		<?php
		// The base url is the url where we'll pass the filter parameters
		$base_url = array('controller' => 'videos', 'action' => 'index');
		echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'filter', 'style' => 'display: flex;position:relative;'));
		// add a select input for each filter. It's a good idea to add a empty value and set
		// the default option to that.
		echo $this->Form->input("accesssite_id", array('style' => 'height: 31px;','label' => 'Access Site', 'options' => $accesssites, 'empty' => '-- All sites --', 'default' => ''));
		//echo $this->Form->input("category_id", array('style' => 'height: 31px;','label' => 'Category', 'options' => $categories, 'empty' => '-- All categories --', 'default' => ''));
		// Add a basic search 
		echo $this->Form->input("search", array('label' => 'Search','style' => 'height: 23px;', 'placeholder' => "Search..."));

		echo $this->Form->submit("Filter", array('style' => 'margin-top: 9px;'));
        //echo '<button type="button" onclick="location.href='.$base_url.'" class="clearinputs">Clear Inputs</button>';

		// To reset all the filters we only need to redirect to the base_url
		echo "<div class='submit actions' style='bottom: 7px; position: absolute;width: 200px !important;'>";
		echo $this->Html->link("Reset filters",$base_url);
		echo "</div>";
		echo $this->Form->end();
		?>
	</div>
    <?php echo $this->Form->create('Video',array('url'=>array('controller'=>'videos','action'=>'videosactions')));?>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th style="padding-right: 12px;"><input style="width: 101%" type="checkbox" name="checkAll" id="checkAll"></th>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('videoid','Brightcove ID'); ?></th>
			<th><?php echo $this->Paginator->sort('duration'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($videos as $video): ?>
	<tr>
        <td>
        <?php echo $this->Form->input($video['Video']['id'],array(
					'type'=>'checkbox',
					'label'=>false,
					'id'=> $video['Video']['id'],
                    'style' => 'width:auto;'
				)); ?>
        </td>
		<td><?php echo h($video['Video']['title']); ?>&nbsp;</td>
		<td><?php echo h($video['Video']['videoid']); ?>&nbsp;</td>
		<td><?php echo h($video['Video']['duration']); ?>&nbsp;</td>
		<td><?php echo h($video['Video']['modified']); ?>&nbsp;</td>
        <td class="actions">
			<?php echo $this->Html->link(__('xml'), array('action' => 'xml', $video['Video']['id'])); ?>
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $video['Video']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $video['Video']['id'])); ?>
			<?php 
                if($deletefirstrow){
                    echo '<a href="JavaScript:deletefirstrow('.$video['Video']['id'].');" >Delete</a>';
                    $deletefirstrow = FALSE;
                }                    
                else
                    echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $video['Video']['id']), array(), __('Are you sure you want to delete # %s?', $video['Video']['id']));
            ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>

    <?php echo $this->Form->end();?>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
    <div class="actions">

        <?php  
        if(count($videos) > 0){

            echo $this->Form->submit('Download Selected XMLs', array('div'=>false, 'name'=>'submit'));
            if(count($movedir) > 0){

                echo $this->Form->submit('Move Selected Videos to:', array('div'=>false, 'name'=>'submit', 'style' => 'margin-left: 1em'));  
            
                echo $this->Form->input('dir',
                array(
                    'label' => '',
                    'options' => $movedir,
                    'div' => array('style' => 'display: inline-block; vertical-align: middle; margin-top: 0.5em;')          
                ));
            }
        }
        ?>

    </div>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<script>
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $("document").ready(function () {
        if(<?php echo $xmldownload ?> != null){
            window.location = "\/videos\/xml\/<?php echo $xmldownload ?>";
        }
    });
    
    function deletefirstrow(videoid) {
        if (confirm('Are you sure you want to delete # ' + videoid + '?')) {
            $.ajax({
                async: true, 
                dataType: "html",
                type: "post",
                url: "\/videos\/delete\/" + videoid
            });
            location.reload();
        } else {
            return false;
        }        
    }
    
</script>