<style>
.actions{
	width: initial !important;
}

</style>


<li><?php echo $this->Html->link(__('New Video'), array('controller' => 'videos', 'action' => 'add')); ?> </li>
<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
<li><?php echo $this->Html->link(__('New Access Site'), array('controller' => 'accesssites', 'action' => 'add')); ?> </li>
<li><?php echo $this->Html->link(__('New Degree'), array('controller' => 'degrees', 'action' => 'add')); ?> </li>
 &nbsp;
<li><?php echo $this->Html->link(__('List Videos'), array('controller' => 'videos', 'action' => 'index')); ?> </li>
<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
<li><?php echo $this->Html->link(__('List Accesssites'), array('controller' => 'accesssites', 'action' => 'index')); ?> </li>
<li><?php echo $this->Html->link(__('List Degrees'), array('controller' => 'degrees', 'action' => 'index')); ?> </li>