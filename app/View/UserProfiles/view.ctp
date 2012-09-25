<?php
	$this->Html->addCrumb($viewUserData['User']['username'], '/UserProfiles/view/'.$viewUserData['User']['id']);
?>
<div class="containerContent">
	<div id="profileContainerContentBackground"></div><div class="clear"></div>
	<?php if($globalUserData['Editor'] == 'true' or $localUserData['Editor'] == 'true' or $globalUserData['Admin'] or $globalUserData['Moderator']	or $localUserData['Moderator']): ?>
	<div class="pageControls">
		<div class="pageControlsTitle">PAGE OPTIONS</div>
		<div class="pageControlsButton">
			<!--<img src="/img/layouts/default/elements/plus.png"><?php echo $this->Html->link(' Reset Password',array('controller' => 'users', 'action' => 'resetPassword&userID=', 'full_base' => true)); ?>-->
			<img src="/img/layouts/default/elements/plus.png"><?php echo $this->Html->link(' Suspend User',array('controller' => 'users', 'action' => 'suspend/'.$viewUserData['User']['id'], 'full_base' => true)); ?>	
			<img src="/img/layouts/default/elements/plus.png"><?php echo $this->Html->link(' Clear Suspension',array('controller' => 'users', 'action' => 'unsuspend/'.$viewUserData['User']['id'], 'full_base' => true)); ?>
		</div>
	</div>
	<?php endif; ?>
	<?php echo $this->Session->flash(); ?>
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
				<?php
					echo $this->Html->link(
					    $this->Html->image("user_profiles/button_account.png", array("alt" => "account")),
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
					<div class="profileUserInfoText" style="font-size: 10px;"><b>Character Name: <?php echo $viewUserData['UserProfile']['display_name']; ?></b></div>
					<?php if(!empty($viewUserData['UserProfile']['server'])): ?>
					<div class="profileUserInfoText" style="font-size: 10px;"><b>Server: <?php echo $viewUserData['UserProfile']['server']; ?></b></div>
					<?php endif; ?>
				</div>
				<div id="profileEditButton">
					<?php 
					if($viewUserData['UserRole']['admin'] == 'true'){
						if($globalUserData['id'] == $viewUserData['User']['id'] or $globalUserData['Admin'] == 'true'){
							echo $this->Html->link(
							    $this->Html->image("layouts/default/buttons/edit.png", array("alt" => "Edit")),
							    array("controller" => "UserProfiles", "action"=>"edit/".$viewUserData['User']['id']),
							    array('escape' => false)
								);
						}
					}else
					if($globalUserData['Moderator'] == 'true' or $localUserData['Moderator'] == 'true' or $globalUserData['id'] == $viewUserData['User']['id']){
						echo $this->Html->link(
						    $this->Html->image("layouts/default/buttons/edit.png", array("alt" => "Edit")),
						    array("controller" => "UserProfiles", "action"=>"edit/".$viewUserData['User']['id']),
						    array('escape' => false)
							);
					}		
					?>
				</div>
			</div>
		</div>
	</div>
	<div id="profileBottomSpacer"></div>
</div>