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
	<?php echo $this->Session->flash(); ?>
	<?php echo $this->Form->create('User', array(
			'inputDefaults' => array(
				'label' => false,
				'div' => 'profileInputContainerStyle',
			)
		)
	);
	?>
	<?php if($this->Form->error('password') || $this->Form->error('password2')): ?>
	<div class ="containerCentered" id="errors" style="margin-bottom: 10px; width: 890px; padding: 5px; left: -2px;">
		<b>Please correct the following errors and resubmit:</b> <br />
		<?php echo $this->Form->error('password'); ?>
		<?php echo $this->Form->error('password2'); ?>
	</div>
	<?php endif; ?>
	<?php echo $this->Form->end() ?>
	<div id="profileContainer">
		<div id="profileBackgroundTop"></div>
		<div id="profileBackgroundBottom"></div>
		<div id="profileLeftColumn">
			<div id="profilePortalLogo"></div>
			<?php if($globalUserData['id'] == $viewUserData['User']['id']): ?>
			<div id="profileNavigationButton">
				<?php
					echo $this->Html->link(
					    $this->Html->image("user_profiles/button_profile.png", array("alt" => "profile")),
					    array("controller" => "UserProfiles", "action"=>"view/".$viewUserData['User']['id']),
					    array('escape' => false)
					);
				?>
			</div>
			<div id="profileNavigationButton">
				<?php
					echo $this->Html->link(
					    $this->Html->image("user_profiles/button_account_active.png", array("alt" => "account")),
					    array("controller" => "UserProfiles", "action"=>"account/".$viewUserData['User']['id']),
					    array('escape' => false)
					);
				?>
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
				</div>
			</div>
			<div class="profileRightColumnContentBg">
				<div class="profileRightColumnContentBgTop"></div>
				<div class="profileRightColumnContentBgBottom"></div>
				<div class="porfileInfoText" style="padding: 5px; color: #dfd0ab; font-weight: bold;">Account Options</div>
				<div style="margin-top: 10px; padding: 5px; color: #dfd0ab; font-weight: bold;  font-size: 11px;">Change Password</div>
				<?php
				echo $this->Form->create('changePassword', array(
						'inputDefaults' => array(
						'label' => false,
						'div' => 'profileInputContainerStyle',
						)
					)
				);
				?>
				<div style="padding: 5px; float: left;">
					<?php 
					echo $this->Form->input('oldPassword', array(
					'label'=>'Old Password:<br/>',
					'class' => 'profileInputStyle',
					'type' => 'password'
					));
					?>
				</div>
				<div style="padding: 5px; float: left;">
					<?php 
					echo $this->Form->input('password', array(
					'label'=>'New Password:<br/>',
					'class' => 'profileInputStyle',
					'type' => 'password'
					));
					?>
				</div>
				<div style="padding: 5px; float: left;">
					<?php 
					echo $this->Form->input('password2', array(
					'label'=>'Confirm New Password:<br/>',
					'class' => 'profileInputStyle',
					'type' => 'password'
					));
					?>
				</div>
				<div class="profileSubmitButton" style="float: left; margin-top: 20px;"><?php echo $this->Form->end('/img/layouts/default/buttons/submit.png'); ?></div>
				<div class="clear"></div>
				<div style="margin-top: 20px; padding: 5px; color: #dfd0ab; font-weight: bold;  font-size: 11px;">Change Email</div>
				<?php
				echo $this->Form->create('changeEmail', array(
				'inputDefaults' => array(
				'label' => false,
				'div' => 'profileInputContainerStyle',
						)
					)
				);
				?>
				<div style="padding: 5px; float: left;">
					<?php 
					echo $this->Form->input('olEmail', array(
					'label'=>'Old Email:<br/>',
					'class' => 'profileInputStyle',
					'error' => ''
					));
					?>
				</div>
				<div style="padding: 5px; float: left;">
					<?php 
					echo $this->Form->input('email', array(
					'label'=>'New Email:<br/>',
					'class' => 'profileInputStyle',
					'error' => ''
					));
					?>
				</div>
				<div style="padding: 5px; float: left;">
					<?php 
					echo $this->Form->input('email2', array(
					'label'=>'Confirm New Email:<br/>',
					'class' => 'profileInputStyle',
					'error' => ''
					));
					?>
				</div>
				<div class="profileSubmitButton" style="float: left; margin-top: 20px;"><?php echo $this->Form->end('/img/layouts/default/buttons/submit.png'); ?></div>
				<div class="clear"></div><div class="verticalSpacer10px"></div>
			</div>
		</div>
	</div>
	<div id="profileBottomSpacer"></div>
</div>