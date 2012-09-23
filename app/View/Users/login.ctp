<div class="containerContent">
	<div id="containerContentBackground"></div>
	<div class="clear"></div>
	<?php echo $this->Session->flash(); ?>
	<div class = "containerCenteredUser" style="margin-top: 20px;">
		<?php echo $this->Form->create('User', array(
			'inputDefaults' => array(
			'label' => false,
			'div' => 'inputStyle',
			'class' => 'inputClass'
					)
				)
			);
		?>
		<div class="clear"></div>
		<div class = "containerCenteredUser" id="registerContainer">
			<div class="divider">
				<div class="registerFormBox"><?php echo $this->Form->input('username', array('before'=>'USER NAME<br />')); ?></div>
				<div class="registerFormBox"><?php echo $this->Form->input('password',  array('before'=>'PASSWORD<br />')); ?></div>
				<div class="verticalSpacer10px"></div><div class="clear"></div>
				<div class="verticalSpacer10px"></div><div class="clear"></div>
				<div class="registerFormBox" style="text-align: center; margin-left: 20px;"><?php echo $this->Form->end('http://media.3hoursdungeon.com/images/Style%20Images/login_button.png'); ?></div>
			</div>
		</div>
	</div>
	<div id="bottomSpacer"></div>
</div>