<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
        <?php echo $this->element('actions'); ?>
	</ul>
</div>
<div class="Dirs view">
    <?php if(!isset($Dir_name)){ ?>
	<div>
        <h2 style="display: inline-block;"><?php echo __('Project Folders'); ?></h2>
        <a href="/dirs/setview/view"><img class="changeview" src="/img/grid.png" /></a>
    </div>

    <?php } else{ ?>

    <div>
        <h2 style="display: inline-block;"><?php echo $Dir_name; ?></h2>
        <a href="/dirs/setview/<?php echo 'view'.'/'.$this->params['pass'][0].'/'.$Dir_name ?>"><img class="changeview" src="/img/grid.png" /></a>
    </div>

    <?php } ?>

    <div style="display: inline-block;">
    <?php 
        if(isset($Dir_name)){     
            echo' <button onclick="JavaScript:window.history.back();" type="button"  class="folderbuttons">Back</button>';
        }
        if(isset($this->params['pass'][0])){
            echo $this->element('createfolder');
            echo '<a href="/Dirs/setproject/listview/'.$this->params['pass'][0].'/'.$Dir_name.'"><button type="button" class="foldersetproject folderbuttons">Set as Current Project Folder</button></a>';
            echo '<a href="/Dirs/deleteproject/listview/'.$this->params['pass'][0].'"><button type="button" class="folderdeleteproject folderbuttons">Delete this Folder</button></a>';
        }else{
            echo $this->element('createfolder');
            echo '<a href="/Dirs/setproject/listview/0"><button type="button" class="foldersetproject folderbuttons">Set as Current Project Folder</button></a>';
        } 
    ?>
    </div>
    <div>
        <table style="margin-bottom: 2%;padding-bottom: 2%;border-bottom-style: dotted;border-bottom-width: thin;" cellpadding="0" cellspacing="0">
	        <tr>
                <th>Folder Name</th>
                <th>SubFolders</th>
                <th>Video Records</th>
            </tr>
            <?php foreach ($Dirs as $Dir): ?>
	        <tr>
                <td><a href="/Dirs/listview/<?php echo $Dir['Dir']['id']; echo "/"; echo $Dir['Dir']['name'] ?>"><img class="smallfolder" src="/img/folder.png" /><?php echo h($Dir['Dir']['name']); ?></a></td>
                <td><?php echo count($Dir['ChildDir']); ?></td>
                <td><a href="/videos/index/<?php echo $Dir['Dir']['id'] ?>"><label><?php echo count($Dir['Video']); ?> Video Record(s)</label></a></td>
            </tr>
        <?php endforeach; ?>
	    </table>

    <?php if(!isset($Dir_name)){ ?>
	<div>
        <a style="color: red" href="/videos/index/0"><p style="display: inline-block;"><?php echo '('.$numvideos.' Videos not in a Folder)' ?></p></a>
    </div>
    <?php } else{ ?>
    <div>
        <a style="color: red" href="/videos/index/<?php echo $this->params['pass'][0] ?>"><p style="display: inline-block;"><?php echo '('.$numvideos.' Videos)' ?></p></a>
    </div>

    <?php } ?>

    <?php echo $this->Form->create('Video',array('id'=>'VideoListForm','url'=>array('controller'=>'videos','action'=>'videosactions')));?>
	<table cellpadding="0" cellspacing="0">
	<tr>
            <th><input style="width: 101%" type="checkbox" name="checkAll" id="checkAll"></th>
			<th><?php echo 'title'; ?></th>
			<th><?php echo 'Brightcove ID'; ?></th>
			<th><?php echo 'Duration'; ?></th>
			<th><?php echo 'Modified'; ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($videos as $video): ?>
	<tr>
        <td>
        <?php echo $this->Form->input($video['Video']['id'],array(
					'type'=>'checkbox',
					'label'=>false,
					'id'=> $video['Video']['id'],
                    'style' => 'width:101%'
				)); ?>
        </td>
		<td><?php echo h($video['Video']['title']); ?>&nbsp;</td>
		<td><?php echo h($video['Video']['videoid']); ?>&nbsp;</td>
		<td><?php echo h($video['Video']['duration']); ?>&nbsp;</td>
		
		<td><?php echo h($video['Video']['modified']); ?>&nbsp;</td>
        <td class="actions">
			<?php echo $this->Html->link(__('xml'), array('controller' => 'videos','action' => 'xml', $video['Video']['id'])); ?>
			<?php echo $this->Html->link(__('View'), array('controller' => 'videos','action' => 'view', $video['Video']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('controller' => 'videos','action' => 'edit', $video['Video']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'videos','action' => 'delete', $video['Video']['id']), array(), __('Are you sure you want to delete # %s?', $video['Video']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>

        <?php echo $this->Form->end();?>
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
    </div>
</div>


<script>

    $("#checkAll").click(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

</script>      