<div class="containerContent">
	<div id="containerContentBackground"></div>
	<div class="clear"></div>
	<?php if($globalUserData['Editor'] == 'true' or $localUserData['Editor'] == 'true'): ?>
	<?php endif; ?>
	<?php echo $this->Session->flash(); ?>
	<?php echo $this->Form->create('Article', array(
										'inputDefaults' => array(
											'label' => false,
											'div' => 'inputStyle',
	 									)
									)
								); 
	?>
	<?php if($this->Form->error('title') || $this->Form->error('body') || $this->Form->error('body_short')): ?>
	<div class = "containerCentered" id="errors">
		<b>Please correct the following errors and resubmit your registration:</b> <br />
		<?php echo $this->Form->error('title'); ?>
		<?php echo $this->Form->error('body_short'); ?>
		<?php echo $this->Form->error('body'); ?>
	</div>
	<?php endif; ?>
	<div class = "containerCentered" style="top: -25px;">
		<div class="formContainer">
			<div class="formField">
				<?php echo $this->Form->input('title', array(
							'before'=>'Article Title<br />', 'error'=>'',
							'class' => 'inputTitle'
					));
				?>
			</div>
			<div class="formField">
				<?php echo $this->Form->input('body_short', array(
						'before'=>'Short Description [Shown on Home Page, Can Include HTML]<br />', 'error'=>'',
						'class' => 'inputTextArea'
					)); 
				?>
			</div>
			<div class="formField">
				<?php echo $this->Form->input('body', array(
						'before'=>'Article Body [Full Article Body Can Include HTML]<br />', 'error'=>'',
						'class' => 'inputTextArea'
					)); 
				?>
			</div>
			<div class="verticalSpacer10px"></div><div class="clear"></div>
			<div class="formFieldSubmit"><?php echo $this->Form->end('/img/layouts/default/buttons/submit.png'); ?></div>
		</div>
		<div class="clear"></div>
	</div>
	<div id="bottomSpacer"></div>
</div>