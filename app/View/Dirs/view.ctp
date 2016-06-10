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
        <a style="color: red" href="/videos/index/0"><p style="display: inline-block;"><?php echo '('.$numvideos.' Videos not in a Folder)' ?></p></a>
        <a href="/dirs/setview/listview"><img class="changeview" src="/img/list.png" /></a>
    </div>

    <?php } else{ ?>

    <div>
        <h2 style="display: inline-block;"><?php echo $Dir_name; ?></h2>
        <a style="color: red" href="/videos/index/<?php echo $this->params['pass'][0] ?>"><p style="display: inline-block;"><?php echo '('.$numvideos.' Videos)' ?></p></a>
        <a href="/dirs/setview/<?php echo 'listview'.'/'.$this->params['pass'][0].'/'.$Dir_name ?>"><img class="changeview" src="/img/list.png" /></a>
    </div>    

    <?php } ?>


    <div style="display: inline-block;">
    <?php 
        if(isset($Dir_name)){     
            echo' <button onclick="JavaScript:window.history.back();" type="button"  class="folderbuttons">Back</button>';
        }
        
        if(isset($this->params['pass'][0])){
            echo $this->element('createfolder');
            echo '<a href="/Dirs/setproject/view/'.$this->params['pass'][0].'/'.$Dir_name.'"><button type="button" class="foldersetproject folderbuttons">Set as Current Project Folder</button></a>';
            echo '<a href="/Dirs/deleteproject/view/'.$this->params['pass'][0].'"><button type="button" class="folderdeleteproject folderbuttons">Delete this Folder</button></a>';
        }else{
            echo $this->element('createfolder');
            echo '<a href="/Dirs/setproject/view/0"><button type="button" class="foldersetproject folderbuttons">Set as Current Project Folder</button></a>';
        } 
    ?>
    </div>
    <div>
	    <?php foreach ($Dirs as $Dir): ?>
    
        <div class="folder_div">
            <a href="/Dirs/view/<?php echo $Dir['Dir']['id']; echo "/"; echo $Dir['Dir']['name'] ?>"><img class="folder" src="/img/folder.png" /></a>
            <label><b><?php echo h($Dir['Dir']['name']); ?></b></label>
            <label><?php echo count($Dir['ChildDir']); ?> SubFolders</label>
            <a href="/videos/index/<?php echo $Dir['Dir']['id'] ?>"><label><?php echo count($Dir['Video']); ?> Video Record(s)</label></a>
        </div>
    
        <?php endforeach; ?>
    </div>
    
    <?php 
    if(count($Dirs) < 1) {
        if(isset($this->params['pass'][0])){
            echo '<a style="color: red" href="/videos/index/'.$this->params['pass'][0].'"><p style="display: inline-block; margin-top: 3%;">'."(Check the ".$numvideos." Videos List)".'</p></a>';   
        }else{
            echo 'There are no folders created yet';  
        }
    }
    if(isset($Dir)) if(count($Dir) > 49){ ?>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} Folders out of {:count} total, starting on Dir {:start}, ending on {:end}')
	));
	?>	
    </p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
    <?php } ?>
</div>


            