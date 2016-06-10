<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
    <link rel="icon" type="image/vnd.microsoft.icon" href="/img/favicon.ico">
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/img/favicon.ico">
	<title>
		<?php /*echo $cakeDescription*/ ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
        
		echo $this->Html->css('cake.generic');
		echo $this->Html->script('jquery.min');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');

        echo $this->Js->writeBuffer(array('cache' => TRUE));
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<img src="/img/mcgrawhill.jpg" style="width: 5%; margin-left: 2%;display: inline-block;vertical-align: middle;">
            <h3 style="display: inline-block;vertical-align: middle;font-size: 215%;margin-bottom: 0;margin-left: 1%;">&#60;&#47;AuthorXML&#62;</h3>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		
		</div>
	</div>
	<?php /*echo $this->element('sql_dump');*/ ?>
</body>
</html>
