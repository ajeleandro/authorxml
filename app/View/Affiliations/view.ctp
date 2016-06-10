<div class="affiliations view">
<h2><?php echo __('Affiliation'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($affiliation['Affiliation']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($affiliation['Affiliation']['Name']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Affiliation'), array('action' => 'edit', $affiliation['Affiliation']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Affiliation'), array('action' => 'delete', $affiliation['Affiliation']['id']), array(), __('Are you sure you want to delete # %s?', $affiliation['Affiliation']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Affiliations'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Affiliation'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Contributors'), array('controller' => 'contributors', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contributor'), array('controller' => 'contributors', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Contributors'); ?></h3>
	<?php if (!empty($affiliation['Contributor'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($affiliation['Contributor'] as $contributor): ?>
		<tr>
			<td><?php echo $contributor['id']; ?></td>
			<td><?php echo $contributor['Name']; ?></td>
			<td><?php echo $contributor['type']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'contributors', 'action' => 'view', $contributor['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'contributors', 'action' => 'edit', $contributor['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'contributors', 'action' => 'delete', $contributor['id']), array(), __('Are you sure you want to delete # %s?', $contributor['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<?php echo $this->element('actions'); ?>
		</ul>
	</div>
</div>
