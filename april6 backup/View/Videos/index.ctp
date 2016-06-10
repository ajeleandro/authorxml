<div class="videos index">
	<h2><?php echo __('List of Video Records'); ?></h2>

    <div class="filters">
		<?php
		// The base url is the url where we'll pass the filter parameters
		$base_url = array('controller' => 'videos', 'action' => 'index');
		echo $this->Form->create("Filter",array('url' => $base_url, 'class' => 'filter', 'style' => 'display: flex;position:relative;'));
		// add a select input for each filter. It's a good idea to add a empty value and set
		// the default option to that.
		echo $this->Form->input("accesssite_id", array('style' => 'height: 31px;','label' => 'Access Site', 'options' => $accesssites, 'empty' => '-- All sites --', 'default' => ''));
		echo $this->Form->input("category_id", array('style' => 'height: 31px;','label' => 'Category', 'options' => $categories, 'empty' => '-- All categories --', 'default' => ''));
		// Add a basic search 
		echo $this->Form->input("search", array('label' => 'Search', 'placeholder' => "Search..."));

		echo $this->Form->submit("Filter", array('style' => 'margin-top: 9px;'));
        //echo '<button type="button" onclick="location.href='.$base_url.'" class="clearinputs">Clear Inputs</button>';

		// To reset all the filters we only need to redirect to the base_url
		echo "<div class='submit actions' style='bottom: 7px; position: absolute;width: 200px;'>";
		echo $this->Html->link("Reset filters",$base_url);
		echo "</div>";
		echo $this->Form->end();
		?>
	</div>

	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('title'); ?></th>
			<th><?php echo $this->Paginator->sort('videoid','Brightcove ID'); ?></th>
			<th><?php echo $this->Paginator->sort('duration'); ?></th>
			<th><?php echo $this->Paginator->sort('category_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($videos as $video): ?>
	<tr>
		<td><?php echo h($video['Video']['title']); ?>&nbsp;</td>
		<td><?php echo h($video['Video']['videoid']); ?>&nbsp;</td>
		<td><?php echo h($video['Video']['duration']); ?>&nbsp;</td>
		<td><?php echo $this->Html->link($video['Category']['name'], array('controller' => 'categories', 'action' => 'view', $video['Category']['id'])); ?></td>
		<td class="actions">
			<?php echo $this->Html->link(__('xml'), array('action' => 'xml', $video['Video']['id'])); ?>
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $video['Video']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $video['Video']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $video['Video']['id']), array(), __('Are you sure you want to delete # %s?', $video['Video']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<?php echo $this->element('actions'); ?>
	</ul>
</div>