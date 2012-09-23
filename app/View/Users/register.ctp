<div class="containerContent">
	<div id="containerContentBackground"></div>
	<div class="clear"></div>
	<?php echo $this->Session->flash(); ?>
	<?php echo $this->Form->create('User');	?>
	<?php if($this->Form->error('username') || $this->Form->error('password') || $this->Form->error('email') || $this->Form->error('password2') || $this->Form->error('email2')): ?>
	<div class="containerCentered" id="errors" style="width: 400px; padding: 10px;">
		<b>Please correct the following errors and resubmit your registration:</b> <br />
		<?php echo $this->Form->error('username'); ?>
		<?php echo $this->Form->error('password'); ?>
		<?php echo $this->Form->error('email'); ?>
	</div>
	<?php endif; ?>
	<?php echo $this->Form->end(); ?>
	<div class="verticalSpacer10px"></div><div class="clear"></div>
	<div class="CenteredUser" style="height: 480px;">
		<?php echo $this->Form->create('User', array(
			'inputDefaults' => array(
			'label' => false,
			'div' => 'inputStyle',
			'class' => 'inputClass'
					)
				)
			);
		?>
		<div class ="divider" style="padding-left: 85px;">
			<div class="registerFormBox"><?php echo $this->Form->input('username', array('before'=>'DESIRED USER NAME<br />', 'error'=>'')); ?></div>
			<div class="registerFormBox"><?php echo $this->Form->input('password', array('before'=>'CREATE A PASSWORD<br />', 'error'=>'')); ?></div>
			<div class="registerFormBox"><?php echo $this->Form->input('password2', array('type' => 'password', 'before'=>'VERIFY PASSWORD<br />', 'error'=>'')); ?></div>
		</div>
		<div class ="divider" style="padding-left: 35px;">
			<div class="registerFormBox"><?php echo $this->Form->input('email', array('before'=>'VALID EMAIL ADDRESS<br />', 'error'=>'')); ?></div>
			<div class="registerFormBox"><?php echo $this->Form->input('email2', array('before'=>'VERIFY EMAIL ADDRESS<br />', 'error'=>'')); ?></div>
			<div class="registerFormBox" style="padding-left: 40px; padding-top: 23px;"><?php echo $this->Form->end('http://media.3hoursdungeon.com/images/Style%20Images/register_button.png'); ?></div>
		</div>
	</div>
	<div id="bottomSpacer"></div>
</div>