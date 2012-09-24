<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
 
 /**
 *
 * 3 Hours Dungeon Gaming Community
 * Developed By Christopher Thoman
 * chris@aswanmedia.com  
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<?php echo $this->Html->docType('html5'); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		3 Hours Dungeon Gaming Community
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('layout');
		echo $this->Html->css('common');
		echo $this->Html->css('../js/markitup/skins/bbcode/style');
		echo $this->Html->css('../js/markitup/sets/bbcode/style');
		echo $this->Html->script('jquery');
		echo $this->Html->script('timings');
		echo $this->Html->script('layout');
		echo $this->Html->script('markitup/jquery.markitup');
		echo $this->Html->script('markitup/sets/bbcode/set');
		echo $this->Html->script('ckeditor/ckeditor');
		echo $this->Html->script('ckeditor/adapters/jquery');
		if (is_file(APP.WEBROOT_DIR.DS."css".DS.$this->params["controller"].DS.$this->params["action"].".css")){ 
		       echo $this->html->css($this->params["controller"]."/".$this->params["action"]); 
		}
		if (is_file(APP.WEBROOT_DIR.DS."js".DS.$this->params["controller"].DS.$this->params["action"].".js")){ 
		       echo $this->Html->script($this->params["controller"]."/".$this->params["action"]); 
		}
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<div id="container">
		<div id="global_header">
			<div id="userControl">
				<div id="userControlLeftBorder"></div>
				<?php if($loggedIn == TRUE): ?>
					<div id="headerLogin">
						<div class="headerLoginButtonContainer">Welcome, <?php echo $globalUserData['UserName'] ?></div>
						<div class="headerLoginButtonContainer"><?php echo $this->Html->link('logout', '/users/logout'); ?></div>
						<div class="headerLoginButtonContainer"><?php echo $this->Html->link('profile', '/UserProfiles/view/'.$globalUserData['id']); ?></div>
					</div>
				<?php else: ?>
					<div id="headerLogin">
						<div class="headerLoginButtonContainer"><?php echo $this->Html->link('Log in', '/users/login'); ?> or <?php echo $this->Html->link('Register an Account', '/users/register'); ?></div>
					</div>
				<?php endif; ?>
				<div id="portals">
				</div>
				<div id="portalsMenu">
				</div>
			</div>
			<div class='clear'></div>
			<div class="headerSearch">
				<?php 
					echo $this->Form->create('Search', array(
							'inputDefaults' => array(
								'label' => false,
								'div' => 'search'
							),
							'url' => array(
								'controller' => 'search',
								'action' => 'index'
							)
						)
					);
					
					echo $this->Form->input('searchQuery', array(
						'type' => 'text',
						'class' => 'searchField',
						'default' => 'Search The GW2 Portal'
						)
					);
					?>
				<div class='searchButton'>
					<?php
						echo $this->Form->end('/img/layouts/default/elements/searchButton.png');
					?>
				</div>
			</div>
		</div>
		<div id="global_navigation">
			<div class="horizontalSpacer10px"></div>
			<div buttonName ="home" class="navigationButton" style="margin-left: 12px;">
				<?php
					echo $this->Html->image("layouts/default/buttons/home.png", array(
					    "alt" => "Home",
					    'url' => array('controller' => 'home', 'action'=>'index')
					));
				?>
			</div>
			<div buttonName ="community" class="navigationButton">
				<?php
					echo $this->Html->image("layouts/default/buttons/community.png", array(
					    "alt" => "Home",
					    'url' => array('controller' => 'forums', 'action'=>'index')
					));
				?>
			</div>
			<div class='breadcrumbs'>
			<?php
				echo $this->Html->getCrumbs($this->Html->image('layouts/default/elements/breadcrumb_arrow.png') , array(
				    'text' => 'Guild Wars 2',
				    'url' => array('controller' => 'home', 'action' => 'index'),
				    'escape' => false
				));
			?>
			</div>
			<div class="socialMedia">
				<!--<div class="socialMediaTitle">Social Media</div>-->
				<div class="socialMediaIcon">
				<?php
					echo $this->Html->link(
					    $this->Html->image("layouts/default/buttons/youtube.png", array("alt" => "YouTube", 'height' => '35px', 'width: 35px')),
					    "http://www.youtube.com/3HoursDungeon",
					    array('target' => "_blank", 'escape' => false)
					);
				?>
				</div>
				<div class="socialMediaIcon">
				<?php				
					echo $this->Html->link(
						$this->Html->image("layouts/default/buttons/twitter.png", array("alt" => "Home", 'height' => '35px', 'width' => '35px')),
						'http://twitter.com/3HoursDungeon',
						array('target' => "_blank", 'escape' => false)
					);
				?>
				</div>
				<div class="socialMediaIcon" style="margin-right: 10px;">
				<?php				
					echo $this->Html->image("layouts/default/buttons/socialmedia_text.png", array("alt" => "Home", 'height' => '35px', 'width' => '100px'));
				?>
				</div>
			</div>
		</div>
		<div id="content">
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="global_footer">
			<div id="footerOne">
			</div>
			<div id="footerTwo"></div>
			<div id="footerThree"></div>
			<div class="clear"></div>
		</div>
		<div id="sql_debug">
			<?php //echo $this->element('sql_dump');?>
			<?php //echo debug($userData); ?>
			<?php //echo debug($forumData); ?>
			<?php //echo debug($test); ?>
			<?php //echo debug(); ?>
		</div>
		<br /><br />
	</div>
</body>