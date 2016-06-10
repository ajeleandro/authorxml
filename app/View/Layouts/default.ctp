<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version());
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
    <link rel="icon" type="image/vnd.microsoft.icon" href="/img/favicon.ico">
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/img/favicon.ico">
	<title>
		<?php echo 'AuthorXML - ' ; echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
        
		echo $this->Html->css('cake.generic');
		echo $this->Html->css('actions');
		echo $this->Html->script('jquery.min');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');

        echo $this->Js->writeBuffer(array('cache' => FALSE));
	?>
</head>
<body>
	<div id="container">
		<div style="background: #323232;" id="header">
			<a href="/"><img src="/img/mcgrawhill.jpg" style="width: 5%; margin-left: 2%;display: inline-block;vertical-align: middle;"></a>
            <h3 style="display: inline-block;vertical-align: middle;font-size: 215%;margin-bottom: 0;margin-left: 1%;">&#60;&#47;AuthorXML&#62;</h3>		
            <?php if($this->Session->read('Auth.User')) { ?>

            <div class="currectproject">
                <div style="display: inline-block;">
                    <p style="margin: 0;color: white"><?php echo $this->Session->read('Auth.User.username'); ?></p>
                    <?php if($this->Session->read('Auth.User.currectprojectid')){ ?>
                        <p style="margin: 0;color: white">Current Project: <a style="color: white;" href="/videos/index/<?php echo $this->Session->read('Auth.User.currectprojectid'); ?>"><?php echo $this->Session->read('Auth.User.currectproject'); ?></a></p>
                    <?php }else{ ?>
                        <a style="color: #003d4c;" href="/dirs/view"><p style="margin: 0;color: white">No Project Folder Selected</p></a>
                    <?php } ?>
                </div>
                <div style="display: inline-block; vertical-align: top;">
                    <a href="/users/logout"><button id="logout_button" style="margin-left: 15px;" type="button"  class="folderbuttons">Logout</button></a>
                </div>
            </div>

            <?php } ?>
        </div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>

		</div>	
	</div>
	<?php /*echo $this->element('sql_dump');*/ ?>
</body>
</html>
