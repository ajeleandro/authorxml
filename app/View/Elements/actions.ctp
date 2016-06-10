<style>
.actions{
	width: initial !important;
}

</style>


<li><?php echo $this->Html->link(__('New Video'), array('controller' => 'videos', 'action' => 'add')); ?> </li>
<li><?php echo $this->Html->link(__('New Category'), array('controller' => 'categories', 'action' => 'add')); ?> </li>
<li><?php echo $this->Html->link(__('New Access Site'), array('controller' => 'accesssites', 'action' => 'add')); ?> </li>
 &nbsp;
<li><?php echo $this->Html->link(__('List All Videos'), array('controller' => 'videos', 'action' => 'index')); ?> </li>
<?php

    if($this->Session->read('Auth.User.folderview') == 0){
        echo '<li>'.$this->Html->link(__('List Folders'), array('controller' => 'dirs', 'action' => 'view')).'</li>';
    }else{
        echo '<li>'.$this->Html->link(__('List Folders'), array('controller' => 'dirs', 'action' => 'listview')).'</li>';
    }

?>

<li><?php echo $this->Html->link(__('List All Folders'), array('controller' => 'dirs', 'action' => 'index')); ?> </li>
<li><?php echo $this->Html->link(__('List Categories'), array('controller' => 'categories', 'action' => 'index')); ?> </li>
<li><?php echo $this->Html->link(__('List Access Sites'), array('controller' => 'accesssites', 'action' => 'index')); ?> </li>
 &nbsp;
<li><?php echo $this->Html->link(__('Brightcove CSV'), array('controller' => 'functions', 'action' => 'brightcovecsv')); ?> </li>