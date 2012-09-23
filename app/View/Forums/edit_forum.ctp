<div class="containerContentFull">
	<?php echo $this->Form->create('FForum', array(
										'inputDefaults' => array(
											'label' => false,
											'div' => 'inputStyle',
	 									)
									)
								);
	?>
	<?php if($this->Form->error('title') || $this->Form->error('description')): ?>
	<div class = "containerCentered" id="errors">
		<b>Please correct the following errors and resubmit:</b> <br />
		<?php echo $this->Form->error('title'); ?>
		<?php echo $this->Form->error('description'); ?>
	</div>
	<?php endif; ?>
	<div class = "containerCentered">
		<div class="formContainer">
			<div class="formField">
				<?php 
					echo $this->Form->input('title', array(
						'before'=>'Forum Name<br />', 'error'=>'',
						'class' => 'inputTitle'
					));
				?>
			</div>
			<div class="formField">
				<?php
					echo $this->Form->input('f_category_id', array(
						'label'=>'Belongs To<br/>', 'error'=>'', 'options' => $categories 
					)); 
				?>
			</div>
			<div class="formField">
				<?php
					echo $this->Form->input('description', array(
						'type' => 'textarea','label'=>'Short Description [115 Character Max]<br/>', 'error'=>'' 
					)); 
				?>
			</div>
			<div class="verticalSpacer10px"></div><div class="clear"></div>
			<div class="formFieldSubmit"><?php echo $this->Form->end('/img/layouts/default/buttons/submit.png'); ?></div>
		</div>
		<div class="clear"></div>
	</div>
</div>