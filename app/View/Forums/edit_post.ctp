<div class="containerContent">
	<?php 
		echo $this->Form->create('FPost', array(
				'inputDefaults' => array(
					'label' => false,
					'error' => ''
				)
			)
		);
	?>
	<div id="CTopicContainerContentBackground"></div><div class="clear"></div>
	<?php echo $this->Session->flash(); ?>
	<?php if($this->Form->error('body')): ?>
		<div class="containerCentered" id="errors" style="top: -15px;">
			<b>Please correct the following errors and resubmit:</b> <br />
			<?php echo $this->Form->error('body'); ?>
		</div>
	<?php endif; ?>
	<div id="CTopicContainer">
		<div id="CTopicBackgroundTop"></div>
		<div id="CTopicLeftColumn">
			<div style="margin-left: 10px; margin-top: 15px; width: 250px; margin-bottom: 15px;">
				<div style="font-weight: bold; font-size: 20px; color: #dfd0ab">Create New Topic</div>
			</div>
			<div class="profileUserInfoContainer" style="margin-left: 10px; margin-top: 10px;">
					<div class="profileUserAvatar">
						<?php
							echo $this->Html->link(
							    $this->Html->image("/img/avatars/".$localUserData['Avatar'].".jpg", array("alt" => "Avatar", "height" => "75px", "width" => "75px")),
							    array("controller" => "UserProfiles", "action"=>"view/".$globalUserData['id']),
							    array('escape' => false)
							);
						?>
					</div>
				</div>
			<div class="profileUserInfoContainer" style="margin-top: 8px;">
				<div class="profileUserInfoText" style="font-size: 14px; margin-bottom: 5px;"><?php echo $this->Html->link($globalUserData['UserName'], array("controller" => "UserProfiles", "action"=>"view/".$globalUserData['id'])); ?></div>
				<div class="profileUserInfoText" style="font-size: 10px; margin-bottom: 2px;"><?php echo $globalUserData['RoleName']; ?></div>
				<div class="profileUserInfoText" style="font-size: 10px; margin-bottom: 2px;"><?php echo $localUserData['Group']; ?></div>
				<div class="profileUserInfoText" style="font-size: 10px; margin-bottom: 2px;"><?php echo $localUserData['Server']; ?></div>
			</div>
		</div>
		<div id="CTopicRightColumn">
			<div class="formContainer">
				<div class="formField">
					<?php 
						echo $this->Form->input('body', array(
							"type" => "textarea",
							"class" => "CTopicBody"
						));
					?>
				</div>
				<div class="formField"><div class="formFieldSubmit"><?php echo $this->Form->end('/img/layouts/default/buttons/submit.png'); ?></div></div>
				<div class="verticalSpacer10px"></div><div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	<div id="CTopicBottomSpacer"></div>
</div>


