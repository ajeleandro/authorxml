<?php
    echo $this->Html->css('buttonfix');
?>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
        <?php echo $this->element('actions'); ?>
	</ul>
</div>
<div class="Folders view">
	<h2><?php echo __('List of all Project Folders in Database'); ?></h2>

    <table style="margin-bottom: 2%;padding-bottom: 2%;border-bottom-style: dotted;border-bottom-width: thin;" cellpadding="0" cellspacing="0">
	        <tr>
                <th>Folder Name</th>
                <th>SubFolders</th>
                <th>Video Records</th>
            </tr>
            <?php foreach ($dirs as $Dir): ?>
	        <tr>
                <td><a href="/Dirs/listview/<?php echo $Dir['Dir']['id']; echo "/"; echo $Dir['Dir']['name'] ?>"><img class="smallfolder" src="/img/folder.png" /><?php echo h($Dir['Dir']['name']); ?></a></td>
                <td><?php echo count($Dir['ChildDir']); ?></td>
                <td><a href="/videos/index/<?php echo $Dir['Dir']['id'] ?>"><label><?php echo count($Dir['Video']); ?> Video Record(s)</label></a></td>
            </tr>
            <?php endforeach; ?>
	</table>
    
    <?php if(isset($dir)) if(count($dir) > 49){ ?>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} folders out of {:count} total, starting on folder {:start}, ending on {:end}')
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