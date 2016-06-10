<div class="accesssites view">
<h2><?php echo __('Access Site'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($accesssite['Accesssite']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($accesssite['Accesssite']['name']); ?>
			&nbsp;
		</dd>
	</dl>
    &nbsp;
    <div class="related">
	<h3><?php echo __('Related Videos'); ?></h3>
	<?php if (!empty($accesssite['Video'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Videoid'); ?></th>
		<th><?php echo __('Title'); ?></th>
		<th><?php echo __('Duration'); ?></th>
		<th><?php echo __('Height'); ?></th>
		<th><?php echo __('Width'); ?></th>
		<th><?php echo __('Player'); ?></th>
		<th><?php echo __('Playerkey'); ?></th>
		<th><?php echo __('Category Id'); ?></th>
		<th><?php echo __('Accesssite Id'); ?></th>
		<th><?php echo __('File Path'); ?></th>
		<th><?php echo __('File Name'); ?></th>
		<th><?php echo __('Chapters And Cue Frames'); ?></th>
		<th><?php echo __('Book Source Line'); ?></th>
		<th><?php echo __('Book Mapping'); ?></th>
		<th><?php echo __('Placement'); ?></th>
		<th><?php echo __('New Label'); ?></th>
		<th><?php echo __('Thumbnail'); ?></th>
		<th><?php echo __('Tags'); ?></th>
		<th><?php echo __('Other Instructions'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($accesssite['Video'] as $video): ?>
		<tr>
			<td><?php echo $video['id']; ?></td>
			<td><?php echo $video['videoid']; ?></td>
			<td><?php echo $video['title']; ?></td>
			<td><?php echo $video['duration']; ?></td>
			<td><?php echo $video['height']; ?></td>
			<td><?php echo $video['width']; ?></td>
			<td><?php echo $video['player']; ?></td>
			<td><?php echo $video['playerkey']; ?></td>
			<td><?php echo $video['category_id']; ?></td>
			<td><?php echo $video['accesssite_id']; ?></td>
			<td><?php echo $video['File Path']; ?></td>
			<td><?php echo $video['File Name']; ?></td>
			<td><?php echo $video['Chapters and Cue Frames']; ?></td>
			<td><?php echo $video['Book Source Line']; ?></td>
			<td><?php echo $video['Book Mapping']; ?></td>
			<td><?php echo $video['Placement']; ?></td>
			<td><?php echo $video['New Label']; ?></td>
			<td><?php echo $video['Thumbnail']; ?></td>
			<td><?php echo $video['Tags']; ?></td>
			<td><?php echo $video['Other Instructions']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'videos', 'action' => 'view', $video['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'videos', 'action' => 'edit', $video['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'videos', 'action' => 'delete', $video['id']), array(), __('Are you sure you want to delete # %s?', $video['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	
</div>
</div>
<div class="actions">
		<ul>
			<?php echo $this->element('actions'); ?>
		</ul>
	</div>

