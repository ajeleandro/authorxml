<?php 
 
?>
<div class="videos view">
<h2><?php echo __('Video'); ?></h2>

    <dl>
		<dt><?php echo __('Access Site'); ?></dt>
		<dd>
			<?php echo h($video['Accesssite']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($video['Video']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Find file here'); ?></dt>
		<dd>
			<?php echo h($video['Video']['File Path']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('File Name'); ?></dt>
		<dd>
			<?php echo h($video['Video']['File Name']); ?>
			&nbsp;
		</dd>
	</dl> 
    &nbsp;
    <h3>Contributors</h3>
	<dl>
        <dt><?php echo __('Authors'); ?></dt>
		    <dd>
                <?php 
                $next = 1; //this is just to print the line break the right way for each contrib
                foreach($video['Contributor'] as $contributors){ 
                    if($next != 1)
                        echo nl2br(" \n");
                    if($contributors['type'] == 0){
			             echo '<b>'.nl2br($contributors['Name']."</b>\n");
                         $aux = 1; //this is just to print the coma the right way for each degree
                         foreach($contributors['Degree'] as $degree){
                            if($aux != 1)
                                echo nl2br(", ");
                            echo nl2br($degree['Name']);
                            $aux = 0;
                         }
                         echo nl2br(" \n");
                         $aux = 1; //this is just to print the line break the right way for each degree
                         foreach($contributors['Affiliation'] as $affiliation){
                            if($aux != 1)
                                echo nl2br(", ");
                            echo nl2br($affiliation['Name']); 
                            $aux = 0;                           
                         }
                    }
                    $next = 0;
                }
                ?>                
		    </dd>
        &nbsp;
        <dt><?php echo __('Medical editors'); ?></dt>
            <dd>
			    <?php 
                $next = 1; //this is just to print the line break the right way for each contrib
                foreach($video['Contributor'] as $contributors){ 
                    if($next != 1)
                        echo nl2br(" \n");
                    if($contributors['type'] == 1){
			             echo '<b>'.nl2br($contributors['Name']."</b>\n");
                         $aux = 1; //this is just to print the coma the right way for each degree
                         foreach($contributors['Degree'] as $degree){
                            if($aux != 1)
                                echo nl2br(", ");
                            echo nl2br($degree['Name']);
                            $aux = 0;
                         }
                         echo nl2br(" \n");
                         $aux = 1; //this is just to print the line break the right way for each degree
                         foreach($contributors['Affiliation'] as $affiliation){
                            if($aux != 1)
                                echo nl2br(", ");
                            echo nl2br($affiliation['Name']); 
                            $aux = 0;                           
                         }
                    }
                    $next = 0;
                }
                ?>  
		    </dd>
	</dl>
    &nbsp;
    <h3>Timing</h3>
	<dl>
		<dt><?php echo __('Chapters and Cue Frames'); ?></dt>
		<dd>
			<?php echo nl2br($video['Video']['Chapters and Cue Frames']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Video Total Run Time'); ?></dt>
		<dd>
			<?php echo h($video['Video']['duration']); ?>
			&nbsp;
		</dd>
	</dl>
    &nbsp;
    <h3>Mapping</h3>
	<dl>
		<dt><?php echo __('Book Source Line'); ?></dt>
		<dd>
			<?php echo h($video['Video']['Book Source Line']); ?>
			&nbsp;
		</dd>
        <dt><?php echo __('Multimedia Category'); ?></dt>
		<dd>
			<?php echo $this->Html->link($video['Category']['name'], array('controller' => 'categories', 'action' => 'view', $video['Category']['id'])); ?>
			&nbsp;
		</dd>
        <dt><?php echo __('Special placement on the site'); ?></dt>
		<dd>
			<?php echo h($video['Video']['Placement']); ?>
			&nbsp;
		</dd>
        <dt><?php echo __('Use "new!" label?'); ?></dt>
		<dd>
			<?php 
                if($video['Video']['New Label'] == 1)
                    echo 'Yes';
                else
                    echo 'No';                
            ?>
			&nbsp;
		</dd>
        <dt><?php echo __('Other Instructions'); ?></dt>
		<dd>
			<?php echo h($video['Video']['Other Instructions']); ?>
			&nbsp;
		</dd>
	</dl>
    &nbsp;
    <h3>Brightcove & Silverchair Info</h3>
	<dl>
		<dt><?php echo __('Brightcove ID'); ?></dt>
		<dd>
			<?php echo h($video['Video']['videoid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Height'); ?></dt>
		<dd>
			<?php echo h($video['Video']['height']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Width'); ?></dt>
		<dd>
			<?php echo h($video['Video']['width']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Player'); ?></dt>
		<dd>
			<?php echo h($video['Video']['player']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Playerkey'); ?></dt>
		<dd>
			<?php echo h($video['Video']['playerkey']); ?>
			&nbsp;
		</dd>
        <dt><?php echo __('Thumbnail'); ?></dt>
		<dd>
			<?php echo h($video['Video']['Thumbnail']); ?>
			&nbsp;
		</dd>
        <dt><?php echo __('Tags'); ?></dt>
		<dd>
			<?php echo h($video['Video']['Tags']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<?php echo $this->element('actions'); ?>
	</ul>
</div>
