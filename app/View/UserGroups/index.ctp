<div class="containerContent">
	<div id="containerContentBackground"></div><div class="clear"></div>
	<?php if($globalUserData['Editor'] == 'true' or $localUserData['Editor'] == 'true'): ?>
	<div class="pageControls">
		<div class="pageControlsTitle">PAGE OPTIONS</div>
		<div class="pageControlsButton"><img src="/img/layouts/default/elements/plus.png"><?php echo $this->Html->link(' Add Group',array('controller' => 'UserGroups', 'action' => 'create', 'full_base' => true));?></div>
	</div>
	<?php endif; ?>
	<?php echo $this->Session->flash(); ?>
	<div id="contentContainer">
		<?php if($pendingGroups != NULL): ?>
			<?php 
				$colorCount = 0;
				$color = '#5b321d';
			?>
			<div class="groupQueueContainer">
				<div class="userName"><b>User Name</b></div>
				<div class="userEmail"><b>E-Mail</b></div>
				<div class="displayName"><b>In-Game Name</b></div>
				<div class="requestingGroup"><b>Asking to join</b></div>
				<div class="action"></div>
			</div>
			<?php foreach($pendingGroups as $group): ?>
				<div class="groupQueueContainer">
					<?php if($colorCount % 2 != 0): ?>
						<div class="userName"><?php echo $group['user_name']; ?></div>
						<div class="userEmail"><?php echo $group['user_email']; ?></div>
						<div class="displayName"><?php echo $group['display_name'] ?></div>
						<div class="requestingGroup"><?php echo $group['group_name'] ?></div>
						<div class="action">
							<div style="float: left;">
								<?php 
									echo $this->Form->create('UserGroup', array(
																			'inputDefaults' => array(
																				'label' => false,
																				'div' => 'profileInputContainerStyle',
										 									)
																		)
																	);
									echo $this->Form->input('user_group_id', array('value' => $group['user_group_id'], 'type' => 'hidden'));
									echo $this->Form->input('user_profile_id', array('value' => $group['user_profile_id'], 'type' => 'hidden'));
									echo $this->Form->input('user_group_queue_id', array('value' => $group['user_group_queue_id'], 'type' => 'hidden'));
									echo $this->Form->input('approve', array('value' => 'true', 'type' => 'hidden'));
									echo $this->Form->end('/img/layouts/default/buttons/approve.png');		
								?>
							</div>
							<div style="float: left; margin-left: 10px;">
								<?php 
									echo $this->Form->create('UserGroup', array(
																			'inputDefaults' => array(
																				'label' => false,
																				'div' => 'profileInputContainerStyle',
										 									)
																		)
																	);
									echo $this->Form->input('user_group_id', array('value' => $group['user_group_id'], 'type' => 'hidden'));
									echo $this->Form->input('user_profile_id', array('value' => $group['user_profile_id'], 'type' => 'hidden'));
									echo $this->Form->input('user_group_queue_id', array('value' => $group['user_group_queue_id'], 'type' => 'hidden'));
									echo $this->Form->input('approve', array('value' => 'false', 'type' => 'hidden'));
									echo $this->Form->end('/img/layouts/default/buttons/deny.png');		
								?>
							</div>
						</div>
					<?php else: ?>
						<div class="userName" style="background:<?php echo $color; ?>;"><?php echo $group['user_name']; ?></div>
						<div class="userEmail" style="background:<?php echo $color; ?>;"><?php echo $group['user_email']; ?></div>
						<div class="displayName" style="background:<?php echo $color; ?>;"><?php echo $group['display_name'] ?></div>
						<div class="requestingGroup" style="background:<?php echo $color; ?>;"><?php echo $group['group_name'] ?></div>
						<div class="action" style="background:<?php echo $color; ?>;">
							<div style="float: left;">
								<?php 
									echo $this->Form->create('UserGroup', array(
																			'inputDefaults' => array(
																				'label' => false,
																				'div' => 'profileInputContainerStyle',
										 									)
																		)
																	);
									echo $this->Form->input('user_group_id', array('value' => $group['user_group_id'], 'type' => 'hidden'));
									echo $this->Form->input('user_profile_id', array('value' => $group['user_profile_id'], 'type' => 'hidden'));
									echo $this->Form->input('user_group_queue_id', array('value' => $group['user_group_queue_id'], 'type' => 'hidden'));
									echo $this->Form->input('approve', array('value' => 'true', 'type' => 'hidden'));
									echo $this->Form->end('/img/layouts/default/buttons/approve.png');		
								?>
							</div>
							<div style="float: left; margin-left: 10px;">
								<?php 
									echo $this->Form->create('UserGroup', array(
																			'inputDefaults' => array(
																				'label' => false,
																				'div' => 'profileInputContainerStyle',
										 									)
																		)
																	);
									echo $this->Form->input('user_group_id', array('value' => $group['user_group_id'], 'type' => 'hidden'));
									echo $this->Form->input('user_profile_id', array('value' => $group['user_profile_id'], 'type' => 'hidden'));
									echo $this->Form->input('user_group_queue_id', array('value' => $group['user_group_queue_id'], 'type' => 'hidden'));
									echo $this->Form->input('approve', array('value' => 'false', 'type' => 'hidden'));
									echo $this->Form->end('/img/layouts/default/buttons/deny.png');		
								?>
							</div>
					</div>
					<?php endif; ?>
				</div>	
			<?php $colorCount = $colorCount+1; endforeach; ?>
		<?php endif; ?>
	</div>
	<div id="bottomSpacer"></div>
</div>