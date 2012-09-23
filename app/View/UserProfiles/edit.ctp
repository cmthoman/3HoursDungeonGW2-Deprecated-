<div class="containerContent">
	<div id="profileContainerContentBackground"></div><div class="clear"></div>
	<?php if($globalUserData['Editor'] == 'true' or $localUserData['Editor'] == 'true'): ?>
	<!--<div class="pageControls">
		<div class="pageControlsTitle">PAGE OPTIONS</div>
		<div class="pageControlsButton">
			<img src="/img/layouts/default/elements/plus.png"><?php echo $this->Html->link(' Add News',array('controller' => 'News', 'action' => 'create', 'full_base' => true)); ?>
		</div>
	</div>-->
	<?php endif; ?>
	<?php echo $this->Form->create('UserProfile', array(
			'inputDefaults' => array(
				'label' => false,
				'div' => 'profileInputContainerStyle',
			)
		)
	);
	?>
	<?php echo $this->Session->flash(); ?>
	<?php if($this->Form->error('server') || $this->Form->error('display_name')): ?>
	<div class = "containerCentered" id="errors" style="margin-bottom: 10px;">
		<b>Please correct the following errors and resubmit:</b> <br />
		<?php echo $this->Form->error('display_name'); ?>
		<?php echo $this->Form->error('server'); ?>
	</div>
	<?php endif; ?>
	<div id="profileContainer">
		<div id="profileBackgroundTop"></div>
		<div id="profileBackgroundBottom"></div>
		<div id="profileLeftColumn">
			<div id="profilePortalLogo"></div>
			<?php if($globalUserData['id'] == $viewUserData['User']['id']): ?>
			<div id="profileNavigationButton">
				<?php
					echo $this->Html->link(
					    $this->Html->image("user_profiles/button_profile_active.png", array("alt" => "profile")),
					    array("controller" => "UserProfiles", "action"=>"view/".$viewUserData['User']['id']),
					    array('escape' => false)
					);
				?>
			</div>
			<div id="profileNavigationButton">
				<?php /*
					echo $this->Html->link(
					    $this->Html->image("user_profiles/button_account.png", array("alt" => "account")),
					    array("controller" => "UserProfiles", "action"=>"account/".$viewUserData['User']['id']),
					    array('escape' => false)
					);
				*/?>
			</div>
			<?php endif; ?>
			<div id="profileLeftColumnBottom"></div>
		</div>
		<div id="profileRightColumn">
			<div class="profileRightColumnContentTransparent">
				<div class="profileUserInfoContainer">
					<div id="profileUserAvatar">
						<?php echo $this->Html->image('/img/avatars/'.$viewUserData['UserProfile']['avatar'].'.jpg', array("alt" => "Avatar")); ?>
					</div>
				</div>
				<div class="profileUserInfoContainer">
					<div class="profileUserInfoText" style="font-size: 16px;"><b><?php echo $viewUserData['User']['username']; ?></b></div>
					<div class="profileUserInfoText" style="font-size: 10px;"><b><?php echo $viewUserData['UserRole']['role_name']; ?></b></div>
					<div class="profileUserInfoText" style="font-size: 10px;"><b><?php echo $viewUserGroupData['UserGroup']['group_name']; ?></b></div>
					<div class="profileUserInfoText" style="font-size: 10px;"><b>Character Name: <?php echo $viewUserData['UserProfile']['display_name']; ?></b></div>
					<?php if(!empty($viewUserData['UserProfile']['server'])): ?>
					<div class="profileUserInfoText" style="font-size: 10px;"><b>Server: <?php echo $viewUserData['UserProfile']['server']; ?></b></div>
					<?php endif; ?>
				</div>
			</div>
			<div class="profileRightColumnContentBg">
				<div class="profileRightColumnContentBgTop"></div>
				<div class="profileRightColumnContentBgBottom"></div>
				<div class="profileUserInfoText" style="margin:5px; font-weight: bold;">Profile Options</div><br/>
				<div class="profileFormField">
				<?php echo $this->Form->input('display_name', array(
					'before'=>'Character Name<br/>', 'error'=>'', 'class' => 'profileInputStyle'
				)); 
				?>
				</div>
				<div class="profileFormField">
				<?php 
					$options = array('' => 'Select A Server', 'Anvil Rock' => 'Anvil Rock', 'Blackgate' => 'Blackgate', 'Borlis Pass' => 'Borlis Pass', 'Crystal Desert' => 'Crystal Desert',
									'Darkhaven' => 'Darkhaven', 'Devonas Rest' => 'Devonas Rest', 'Dragon Brand' => 'Dragon Brand', 'Ehmry Bay' => 'Ehmry Bay',
									'Eredon Terrace' => 'Eredon Terrace', 'Fergusons Crossing' => 'Fergusons Crossing', 'Fort Aspenwood' => 'Fort Aspenwood',
									'Gate of Madness' => 'Gate of Madness', 'Henge of Denravi' => 'Henge of Denravi', 'Isle of Janthir' => 'Isle of Janthir',
									'Jade Quarry' => 'Jade Quarry', 'Kaineng' => 'Kaineng', 'Maguuma' => 'Maguuma', 'Northern Shiverpeaks' => 'Northern Shiverpeaks',
									'Sanctum of Rall' => 'Sanctum of Rall', 'Sea of Sorrows' => 'Sea of Sorrows', 'Sorrows Furnace' => 'Sorrows Furnace',
									'Stormbluff Isle' => 'Stormbluff Isle', 'Tarnished Coast' => 'Tarnished Coast', 'Yaks Bend' => 'Yaks Bend'
								);
					echo $this->Form->input('server', array(
						'label'=>'Server<br/>', 'error'=>'', 'options' => $options, 'selected' => $viewUserData['UserProfile']['server'], 
						'empty' => array('' => 'Select a Server')
					)); 
				?>
				</div>
				<div class="profileFormField">
				<?php
				if($hideGroupDropdown != 'true'){
					$options = $groups;
					echo $this->Form->input('user_group_id', array(
						'label'=>'Group<br/>', 'error'=>'', 'options' => $options, 'selected' => $viewUserData['UserProfile']['user_group_id']
					));
				}					
				?>
				</div>
				<br />
				<div class="profileSubmitButton" style="float: left;"><?php echo $this->Form->end('/img/layouts/default/buttons/submit.png'); ?></div>
			</div>
			<?php if($Access == 'User'): ?>
				<?php if($hideGroupApplication == 'false'): ?>
				<div class="profileRightColumnContentBg">
					<div class="profileRightColumnContentBgTop"></div>
					<div class="profileRightColumnContentBgBottom"></div>
					<div class="profileUserInfoText" style="margin:5px; font-weight: bold;">Groups</div>
					<div class="profileUserInfoText" style="margin:5px;">You are currently in the group: <b><?php echo $viewUserGroupData['UserGroup']['group_name']; ?></b></div>
					<div class="profileUserInfoText" style="margin:5px;">You may only be in one group at a time. Available groups are listed below. To join a group, you must apply and a site staff member must approve your request.</div><br/><br/>
					<?php if($availableGroups == NULL): ?>
						<div class='profileGroupHeader'>There are no groups available to join at this time.</div><br /><br />
					<?php else: ?>
						<?php $groupCount = 1; foreach($availableGroups as $group):?>
							<?php echo $this->Form->create('UserGroupQueue', array(
												'inputDefaults' => array(
													'label' => false,
													'div' => 'profileInputContainerStyle',
			 									)
											)
										);
										echo $this->Form->input('user_group_id', array('value' => $group['UserGroup']['id'], 'type' => 'hidden'));
										echo $this->Form->input('user_id', array('value' => $viewUserData['User']['id'], 'type' => 'hidden'));
										echo $this->Form->input('user_group_name', array('value' => $group['UserGroup']['group_name'], 'type' => 'hidden'));
							?>
							<?php if($groupCount == 1): ?>
							<div class='profileGroupContainer' style='border-top: 1px solid #472001;'>
								<div class='profileGroupHeader'><?php echo $group['UserGroup']['group_name'] ?></div>
								<div class="profileUserInfoText" style="margin:5px; float: left;"><?php echo $group['UserGroup']['description']; ?></div>
								<div class="profileSubmitButton" style="float: right;"><?php echo $this->Form->end('/img/layouts/default/buttons/apply.png'); ?></div>
							</div>
							<?php else: ?>
							<div class='profileGroupContainer'>
								<div class='profileGroupHeader'><?php echo $group['UserGroup']['group_name'] ?></div>
								<div class="profileUserInfoText" style="margin:5px; float: left;"><?php echo $group['UserGroup']['description']; ?></div>
								<div class="profileSubmitButton" style="float: right;"><?php echo $this->Form->end('/img/layouts/default/buttons/apply.png'); ?></div>
							</div>
							<?php endif; $groupCount = $groupCount + 1; ?>
						<?php endforeach; ?>
					<?php endif; ?>
					<br />
				</div>
				<?php else: ?>
					<div class="profileRightColumnContentBg">
						<div class="profileRightColumnContentBgTop"></div>
						<div class="profileRightColumnContentBgBottom"></div>
						<div class="profileUserInfoText" style="margin:5px; font-weight: bold;">Groups</div>
						<div class="profileUserInfoText" style="margin:5px;">You are waiting approval to join the group: <b><?php echo $pendingGroup; ?>.</b></div>
						<div class="profileUserInfoText" style="margin:5px;">You may not apply to join another group until your previous request has been reviewed</div>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
	</div>
	<div id="profileBottomSpacer"></div>
</div>