<div class="containerContentFull">
	<?php echo $this->Form->create('FCategory', array(
										'inputDefaults' => array(
											'label' => false,
											'div' => 'inputStyle',
	 									)
									)
								);
	?>
	<?php if($this->Form->error('name')): ?>
	<div class = "containerCentered" id="errors">
		<b>Please correct the following errors and resubmit:</b> <br />
		<?php echo $this->Form->error('name'); ?>
	</div>
	<?php endif; ?>
	<div class = "containerCentered">
		<div class="formContainer">
			<div class="formField">
				<?php 
					echo $this->Form->input('name', array(
						'before'=>'Category Name<br />', 'error'=>'',
						'class' => 'inputTitle'
					));
				?>
			</div>
			<div class="formField">
				<?php
					echo $this->Form->input('group', array(
						'label'=>'Visible By<br/>', 'error'=>'', 'options' => $groups, 'selected' => 'Public'
					)); 
				?>
			</div>
			<div class="verticalSpacer10px"></div><div class="clear"></div>
			<div class="formFieldSubmit"><?php echo $this->Form->end('/img/layouts/default/buttons/submit.png'); ?></div>
			<!--<div class="formFieldSubmit" style="clear: both; margin-top: 25px;">
			<?php
				echo $this->Html->link(
				    $this->Html->image("layouts/default/buttons/delete.png", array("alt" => "Delete")),
				    array("controller" => "Forums", "action"=>"deleteCategory/".$id),
				    array('escape' => false), "Delete this forum category forever!?"
				);
			?>
			</div>-->
		</div>
		<div class="clear"></div>
	</div>
</div>