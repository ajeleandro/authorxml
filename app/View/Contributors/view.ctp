<div class="contributors view">
<h2><?php echo __('Contributor'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($contributor['Contributor']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($contributor['Contributor']['Name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($contributor['Contributor']['type']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Contributor'), array('action' => 'edit', $contributor['Contributor']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Contributor'), array('action' => 'delete', $contributor['Contributor']['id']), array(), __('Are you sure you want to delete # %s?', $contributor['Contributor']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Contributors'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contributor'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Affiliations'), array('controller' => 'affiliations', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Affiliation'), array('controller' => 'affiliations', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Degrees'), array('controller' => 'degrees', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Degree'), array('controller' => 'degrees', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Affiliations'); ?></h3>
	<?php if (!empty($contributor['Affiliation'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($contributor['Affiliation'] as $affiliation): ?>
		<tr>
			<td><?php echo $affiliation['id']; ?></td>
			<td><?php echo $affiliation['Name']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'affiliations', 'action' => 'view', $affiliation['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'affiliations', 'action' => 'edit', $affiliation['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'affiliations', 'action' => 'delete', $affiliation['id']), array(), __('Are you sure you want to delete # %s?', $affiliation['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Affiliation'), array('controller' => 'affiliations', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Degrees'); ?></h3>
	<?php if (!empty($contributor['Degree'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($contributor['Degree'] as $degree): ?>
		<tr>
			<td><?php echo $degree['id']; ?></td>
			<td><?php echo $degree['Name']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'degrees', 'action' => 'view', $degree['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'degrees', 'action' => 'edit', $degree['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'degrees', 'action' => 'delete', $degree['id']), array(), __('Are you sure you want to delete # %s?', $degree['id'])); ?>
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
